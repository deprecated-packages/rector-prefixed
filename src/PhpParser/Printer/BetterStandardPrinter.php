<?php

declare (strict_types=1);
namespace Rector\Core\PhpParser\Printer;

use RectorPrefix20210408\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\Yield_;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Scalar\DNumber;
use PhpParser\Node\Scalar\EncapsedStringPart;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Declare_;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Nop;
use PhpParser\Node\Stmt\TraitUse;
use PhpParser\Node\Stmt\Use_;
use PhpParser\PrettyPrinter\Standard;
use Rector\Comments\NodeDocBlock\DocBlockUpdater;
use Rector\Core\PhpParser\Node\CustomNode\FileNode;
use Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace;
use Rector\Core\PhpParser\Printer\Whitespace\IndentCharacterDetector;
use Rector\NodeTypeResolver\Node\AttributeKey;
/**
 * @see \Rector\Core\Tests\PhpParser\Printer\BetterStandardPrinterTest
 */
final class BetterStandardPrinter extends \PhpParser\PrettyPrinter\Standard
{
    /**
     * @var string
     * @see https://regex101.com/r/jUFizd/1
     */
    private const NEWLINE_END_REGEX = "#\n\$#";
    /**
     * @var string
     * @see https://regex101.com/r/F5x783/1
     */
    private const USE_REGEX = '#( use)\\(#';
    /**
     * @var string
     * @see https://regex101.com/r/DrsMY4/1
     */
    private const QUOTED_SLASH_REGEX = "#'|\\\\(?=[\\\\']|\$)#";
    /**
     * Remove extra spaces before new Nop_ nodes
     * @see https://regex101.com/r/iSvroO/1
     * @var string
     */
    private const EXTRA_SPACE_BEFORE_NOP_REGEX = '#^[ \\t]+$#m';
    /**
     * @see https://regex101.com/r/qZiqGo/4
     * @var string
     */
    private const REPLACE_COLON_WITH_SPACE_REGEX = '#(function .*?\\(.*?\\)) : #';
    /**
     * Use space by default
     * @var string
     */
    private $tabOrSpaceIndentCharacter = ' ';
    /**
     * @var DocBlockUpdater
     */
    private $docBlockUpdater;
    /**
     * @var IndentCharacterDetector
     */
    private $indentCharacterDetector;
    /**
     * @param mixed[] $options
     */
    public function __construct(\Rector\Core\PhpParser\Printer\Whitespace\IndentCharacterDetector $indentCharacterDetector, \Rector\Comments\NodeDocBlock\DocBlockUpdater $docBlockUpdater, array $options = [])
    {
        parent::__construct($options);
        // print return type double colon right after the bracket "function(): string"
        $this->initializeInsertionMap();
        $this->insertionMap['Stmt_ClassMethod->returnType'] = [')', \false, ': ', null];
        $this->insertionMap['Stmt_Function->returnType'] = [')', \false, ': ', null];
        $this->insertionMap['Expr_Closure->returnType'] = [')', \false, ': ', null];
        $this->indentCharacterDetector = $indentCharacterDetector;
        $this->docBlockUpdater = $docBlockUpdater;
    }
    /**
     * @param Node[] $stmts
     * @param Node[] $origStmts
     * @param mixed[] $origTokens
     */
    public function printFormatPreserving(array $stmts, array $origStmts, array $origTokens) : string
    {
        $newStmts = $this->resolveNewStmts($stmts);
        // detect per print
        $this->tabOrSpaceIndentCharacter = $this->indentCharacterDetector->detect($newStmts);
        $content = parent::printFormatPreserving($newStmts, $origStmts, $origTokens);
        // add new line in case of added stmts
        if (\count($stmts) !== \count($origStmts) && !(bool) \RectorPrefix20210408\Nette\Utils\Strings::match($content, self::NEWLINE_END_REGEX)) {
            $content .= $this->nl;
        }
        return $content;
    }
    /**
     * @param Node|Node[]|null $node
     */
    public function print($node) : string
    {
        if ($node === null) {
            $node = [];
        }
        if (!\is_array($node)) {
            $node = [$node];
        }
        return $this->prettyPrint($node);
    }
    /**
     * @param Node[] $stmts
     */
    public function prettyPrintFile(array $stmts) : string
    {
        // to keep indexes from 0
        $stmts = \array_values($stmts);
        return parent::prettyPrintFile($stmts) . \PHP_EOL;
    }
    public function pFileWithoutNamespace(\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace $fileWithoutNamespace) : string
    {
        $content = $this->pStmts($fileWithoutNamespace->stmts, \false);
        return \ltrim($content);
    }
    public function pFileNode(\Rector\Core\PhpParser\Node\CustomNode\FileNode $fileNode) : string
    {
        return $this->pStmts($fileNode->stmts);
    }
    /**
     * This allows to use both spaces and tabs vs. original space-only
     */
    protected function setIndentLevel(int $level) : void
    {
        $level = \max($level, 0);
        $this->indentLevel = $level;
        $this->nl = "\n" . \str_repeat($this->tabOrSpaceIndentCharacter, $level);
    }
    /**
     * This allows to use both spaces and tabs vs. original space-only
     */
    protected function indent() : void
    {
        $multiplier = $this->tabOrSpaceIndentCharacter === ' ' ? 4 : 1;
        $this->indentLevel += $multiplier;
        $this->nl .= \str_repeat($this->tabOrSpaceIndentCharacter, $multiplier);
    }
    /**
     * This allows to use both spaces and tabs vs. original space-only
     */
    protected function outdent() : void
    {
        if ($this->tabOrSpaceIndentCharacter === ' ') {
            // - 4 spaces
            \assert($this->indentLevel >= 4);
            $this->indentLevel -= 4;
        } else {
            // - 1 tab
            \assert($this->indentLevel >= 1);
            --$this->indentLevel;
        }
        $this->nl = "\n" . \str_repeat($this->tabOrSpaceIndentCharacter, $this->indentLevel);
    }
    /**
     * @param mixed[] $nodes
     * @param mixed[] $origNodes
     * @param int|null $fixup
     */
    protected function pArray(array $nodes, array $origNodes, int &$pos, int $indentAdjustment, string $parentNodeType, string $subNodeName, $fixup) : ?string
    {
        // reindex positions for printer
        $nodes = \array_values($nodes);
        $this->moveCommentsFromAttributeObjectToCommentsAttribute($nodes);
        $content = parent::pArray($nodes, $origNodes, $pos, $indentAdjustment, $parentNodeType, $subNodeName, $fixup);
        if ($content === null) {
            return $content;
        }
        if (!$this->containsNop($nodes)) {
            return $content;
        }
        return \RectorPrefix20210408\Nette\Utils\Strings::replace($content, self::EXTRA_SPACE_BEFORE_NOP_REGEX, '');
    }
    /**
     * Do not preslash all slashes (parent behavior), but only those:
     *
     * - followed by "\"
     * - by "'"
     * - or the end of the string
     *
     * Prevents `Vendor\Class` => `Vendor\\Class`.
     */
    protected function pSingleQuotedString(string $string) : string
    {
        return "'" . \RectorPrefix20210408\Nette\Utils\Strings::replace($string, self::QUOTED_SLASH_REGEX, '\\\\$0') . "'";
    }
    /**
     * Emulates 1_000 in PHP 7.3- version
     */
    protected function pScalar_DNumber(\PhpParser\Node\Scalar\DNumber $dNumber) : string
    {
        if (\is_string($dNumber->value)) {
            return $dNumber->value;
        }
        return parent::pScalar_DNumber($dNumber);
    }
    /**
     * Add space:
     * "use("
     * ↓
     * "use ("
     */
    protected function pExpr_Closure(\PhpParser\Node\Expr\Closure $closure) : string
    {
        $closureContent = parent::pExpr_Closure($closure);
        return \RectorPrefix20210408\Nette\Utils\Strings::replace($closureContent, self::USE_REGEX, '$1 (');
    }
    /**
     * Do not add "()" on Expressions
     * @see https://github.com/rectorphp/rector/pull/401#discussion_r181487199
     */
    protected function pExpr_Yield(\PhpParser\Node\Expr\Yield_ $yield) : string
    {
        if ($yield->value === null) {
            return 'yield';
        }
        $parentNode = $yield->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        $shouldAddBrackets = !$parentNode instanceof \PhpParser\Node\Stmt\Expression;
        return \sprintf('%syield %s%s%s', $shouldAddBrackets ? '(' : '', $yield->key !== null ? $this->p($yield->key) . ' => ' : '', $this->p($yield->value), $shouldAddBrackets ? ')' : '');
    }
    /**
     * Print arrays in short [] by default,
     * to prevent manual explicit array shortening.
     */
    protected function pExpr_Array(\PhpParser\Node\Expr\Array_ $array) : string
    {
        if (!$array->hasAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::KIND)) {
            $array->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::KIND, \PhpParser\Node\Expr\Array_::KIND_SHORT);
        }
        return parent::pExpr_Array($array);
    }
    /**
     * Fixes escaping of regular patterns
     */
    protected function pScalar_String(\PhpParser\Node\Scalar\String_ $string) : string
    {
        $isRegularPattern = $string->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::IS_REGULAR_PATTERN);
        if (!$isRegularPattern) {
            return parent::pScalar_String($string);
        }
        $kind = $string->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::KIND, \PhpParser\Node\Scalar\String_::KIND_SINGLE_QUOTED);
        if ($kind === \PhpParser\Node\Scalar\String_::KIND_DOUBLE_QUOTED) {
            return $this->wrapValueWith($string, '"');
        }
        if ($kind === \PhpParser\Node\Scalar\String_::KIND_SINGLE_QUOTED) {
            return $this->wrapValueWith($string, "'");
        }
        return parent::pScalar_String($string);
    }
    /**
     * @param Node[] $nodes
     */
    protected function pStmts(array $nodes, bool $indent = \true) : string
    {
        $this->moveCommentsFromAttributeObjectToCommentsAttribute($nodes);
        return parent::pStmts($nodes, $indent);
    }
    /**
     * "...$params) : ReturnType"
     * ↓
     * "...$params): ReturnType"
     */
    protected function pStmt_ClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod) : string
    {
        $content = parent::pStmt_ClassMethod($classMethod);
        // this approach is chosen, to keep changes in parent pStmt_ClassMethod() updated
        return \RectorPrefix20210408\Nette\Utils\Strings::replace($content, self::REPLACE_COLON_WITH_SPACE_REGEX, '$1: ');
    }
    /**
     * Clean class and trait from empty "use x;" for traits causing invalid code
     */
    protected function pStmt_Class(\PhpParser\Node\Stmt\Class_ $class) : string
    {
        $shouldReindex = \false;
        foreach ($class->stmts as $key => $stmt) {
            // remove empty ones
            if ($stmt instanceof \PhpParser\Node\Stmt\TraitUse && $stmt->traits === []) {
                unset($class->stmts[$key]);
                $shouldReindex = \true;
            }
        }
        if ($shouldReindex) {
            $class->stmts = \array_values($class->stmts);
        }
        return parent::pStmt_Class($class);
    }
    /**
     * It remove all spaces extra to parent
     */
    protected function pStmt_Declare(\PhpParser\Node\Stmt\Declare_ $declare) : string
    {
        $declareString = parent::pStmt_Declare($declare);
        return \RectorPrefix20210408\Nette\Utils\Strings::replace($declareString, '#\\s+#', '');
    }
    /**
     * Remove extra \\ from FQN use imports, for easier use in the code
     */
    protected function pStmt_Use(\PhpParser\Node\Stmt\Use_ $use) : string
    {
        if ($use->type !== \PhpParser\Node\Stmt\Use_::TYPE_NORMAL) {
            return parent::pStmt_Use($use);
        }
        foreach ($use->uses as $useUse) {
            if (!$useUse->name instanceof \PhpParser\Node\Name\FullyQualified) {
                continue;
            }
            $useUse->name = new \PhpParser\Node\Name($useUse->name->toString());
        }
        return parent::pStmt_Use($use);
    }
    protected function pScalar_EncapsedStringPart(\PhpParser\Node\Scalar\EncapsedStringPart $encapsedStringPart) : string
    {
        // parent throws exception, but we need to compare string
        return '`' . $encapsedStringPart->value . '`';
    }
    protected function pCommaSeparated(array $nodes) : string
    {
        $result = parent::pCommaSeparated($nodes);
        $last = \end($nodes);
        if ($last instanceof \PhpParser\Node) {
            $trailingComma = $last->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FUNC_ARGS_TRAILING_COMMA);
            if ($trailingComma === \false) {
                $result = \rtrim($result, ',');
            }
        }
        return $result;
    }
    /**
     * @param Node[] $stmts
     * @return Node[]|mixed[]
     */
    private function resolveNewStmts(array $stmts) : array
    {
        if (\count($stmts) === 1 && $stmts[0] instanceof \Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace) {
            return $stmts[0]->stmts;
        }
        return $stmts;
    }
    /**
     * @param array<Node|null> $nodes
     */
    private function moveCommentsFromAttributeObjectToCommentsAttribute(array $nodes) : void
    {
        // move phpdoc from node to "comment" attribute
        foreach ($nodes as $node) {
            if (!$node instanceof \PhpParser\Node) {
                continue;
            }
            $this->docBlockUpdater->updateNodeWithPhpDocInfo($node);
        }
    }
    /**
     * @param Node[] $nodes
     */
    private function containsNop(array $nodes) : bool
    {
        foreach ($nodes as $node) {
            if ($node instanceof \PhpParser\Node\Stmt\Nop) {
                return \true;
            }
        }
        return \false;
    }
    private function wrapValueWith(\PhpParser\Node\Scalar\String_ $string, string $wrap) : string
    {
        return $wrap . $string->value . $wrap;
    }
}
