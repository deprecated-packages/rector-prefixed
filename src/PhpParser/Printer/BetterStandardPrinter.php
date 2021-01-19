<?php

declare (strict_types=1);
namespace Rector\Core\PhpParser\Printer;

use RectorPrefix20210119\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\Yield_;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Scalar\DNumber;
use PhpParser\Node\Scalar\EncapsedStringPart;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Declare_;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Nop;
use PhpParser\Node\Stmt\TraitUse;
use PhpParser\Node\Stmt\Use_;
use PhpParser\PrettyPrinter\Standard;
use Rector\Core\PhpParser\Node\CustomNode\FileNode;
use Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockManipulator;
use RectorPrefix20210119\Symplify\SmartFileSystem\SmartFileInfo;
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
     * @see https://regex101.com/r/w5E8Rh/1
     */
    private const FOUR_SPACE_START_REGEX = '#^ {4}#m';
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
     * @var DocBlockManipulator
     */
    private $docBlockManipulator;
    /**
     * @var CommentRemover
     */
    private $commentRemover;
    /**
     * @var ContentPatcher
     */
    private $contentPatcher;
    /**
     * @param mixed[] $options
     */
    public function __construct(\Rector\Core\PhpParser\Printer\CommentRemover $commentRemover, \Rector\Core\PhpParser\Printer\ContentPatcher $contentPatcher, array $options = [])
    {
        parent::__construct($options);
        // print return type double colon right after the bracket "function(): string"
        $this->initializeInsertionMap();
        $this->insertionMap['Stmt_ClassMethod->returnType'] = [')', \false, ': ', null];
        $this->insertionMap['Stmt_Function->returnType'] = [')', \false, ': ', null];
        $this->insertionMap['Expr_Closure->returnType'] = [')', \false, ': ', null];
        $this->commentRemover = $commentRemover;
        $this->contentPatcher = $contentPatcher;
    }
    /**
     * @required
     */
    public function autowireBetterStandardPrinter(\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockManipulator $docBlockManipulator) : void
    {
        $this->docBlockManipulator = $docBlockManipulator;
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
        $this->detectTabOrSpaceIndentCharacter($newStmts);
        $content = parent::printFormatPreserving($newStmts, $origStmts, $origTokens);
        $contentOriginal = $this->print($origStmts);
        $content = $this->contentPatcher->rollbackValidAnnotation($contentOriginal, $content, \Rector\Core\PhpParser\Printer\ContentPatcher::VALID_ANNOTATION_STRING_REGEX, \Rector\Core\PhpParser\Printer\ContentPatcher::INVALID_ANNOTATION_STRING_REGEX);
        $content = $this->contentPatcher->rollbackValidAnnotation($contentOriginal, $content, \Rector\Core\PhpParser\Printer\ContentPatcher::VALID_ANNOTATION_ROUTE_REGEX, \Rector\Core\PhpParser\Printer\ContentPatcher::INVALID_ANNOTATION_ROUTE_REGEX);
        $content = $this->contentPatcher->rollbackValidAnnotation($contentOriginal, $content, \Rector\Core\PhpParser\Printer\ContentPatcher::VALID_ANNOTATION_COMMENT_REGEX, \Rector\Core\PhpParser\Printer\ContentPatcher::INVALID_ANNOTATION_COMMENT_REGEX);
        $content = $this->contentPatcher->rollbackValidAnnotation($contentOriginal, $content, \Rector\Core\PhpParser\Printer\ContentPatcher::VALID_ANNOTATION_CONSTRAINT_REGEX, \Rector\Core\PhpParser\Printer\ContentPatcher::INVALID_ANNOTATION_CONSTRAINT_REGEX);
        $content = $this->contentPatcher->rollbackValidAnnotation($contentOriginal, $content, \Rector\Core\PhpParser\Printer\ContentPatcher::VALID_ANNOTATION_ROUTE_OPTION_REGEX, \Rector\Core\PhpParser\Printer\ContentPatcher::INVALID_ANNOTATION_ROUTE_OPTION_REGEX);
        $content = $this->contentPatcher->rollbackValidAnnotation($contentOriginal, $content, \Rector\Core\PhpParser\Printer\ContentPatcher::VALID_ANNOTATION_ROUTE_LOCALIZATION_REGEX, \Rector\Core\PhpParser\Printer\ContentPatcher::INVALID_ANNOTATION_ROUTE_LOCALIZATION_REGEX);
        $content = $this->contentPatcher->rollbackValidAnnotation($contentOriginal, $content, \Rector\Core\PhpParser\Printer\ContentPatcher::VALID_ANNOTATION_VAR_RETURN_EXPLICIT_FORMAT_REGEX, \Rector\Core\PhpParser\Printer\ContentPatcher::INVALID_ANNOTATION_VAR_RETURN_EXPLICIT_FORMAT_REGEX);
        $content = $this->contentPatcher->rollbackDuplicateComment($contentOriginal, $content);
        // add new line in case of added stmts
        if (\count($stmts) !== \count($origStmts) && !(bool) \RectorPrefix20210119\Nette\Utils\Strings::match($content, self::NEWLINE_END_REGEX)) {
            $content .= $this->nl;
        }
        return $content;
    }
    /**
     * @param Node|Node[]|null $node
     */
    public function printWithoutComments($node) : string
    {
        $printerNode = $this->print($node);
        $nodeWithoutComments = $this->commentRemover->remove($printerNode);
        return \trim($nodeWithoutComments);
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
     * Removes all comments from both nodes
     *
     * @param Node|Node[]|null $firstNode
     * @param Node|Node[]|null $secondNode
     */
    public function areNodesEqual($firstNode, $secondNode) : bool
    {
        return $this->printWithoutComments($firstNode) === $this->printWithoutComments($secondNode);
    }
    /**
     * @param Node[] $stmts Array of statements
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
     * @param Node[] $availableNodes
     */
    public function isNodeEqual(\PhpParser\Node $singleNode, array $availableNodes) : bool
    {
        // remove comments, only content is relevant
        $singleNode = clone $singleNode;
        $singleNode->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, null);
        foreach ($availableNodes as $availableNode) {
            // remove comments, only content is relevant
            $availableNode = clone $availableNode;
            $availableNode->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, null);
            if ($this->areNodesEqual($singleNode, $availableNode)) {
                return \true;
            }
        }
        return \false;
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
        return \RectorPrefix20210119\Nette\Utils\Strings::replace($content, self::EXTRA_SPACE_BEFORE_NOP_REGEX, '');
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
        return "'" . \RectorPrefix20210119\Nette\Utils\Strings::replace($string, self::QUOTED_SLASH_REGEX, '\\\\$0') . "'";
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
        return \RectorPrefix20210119\Nette\Utils\Strings::replace($closureContent, self::USE_REGEX, '$1 (');
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
        $shouldAddBrackets = $parentNode instanceof \PhpParser\Node\Stmt\Expression;
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
        if ($isRegularPattern) {
            $kind = $string->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::KIND, \PhpParser\Node\Scalar\String_::KIND_SINGLE_QUOTED);
            if ($kind === \PhpParser\Node\Scalar\String_::KIND_DOUBLE_QUOTED) {
                return $this->wrapValueWith($string, '"');
            }
            if ($kind === \PhpParser\Node\Scalar\String_::KIND_SINGLE_QUOTED) {
                return $this->wrapValueWith($string, "'");
            }
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
        return \RectorPrefix20210119\Nette\Utils\Strings::replace($content, self::REPLACE_COLON_WITH_SPACE_REGEX, '$1: ');
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
        return \RectorPrefix20210119\Nette\Utils\Strings::replace($declareString, '#\\s+#', '');
    }
    /**
     * Remove extra \\ from FQN use imports, for easier use in the code
     */
    protected function pStmt_Use(\PhpParser\Node\Stmt\Use_ $use) : string
    {
        if ($use->type === \PhpParser\Node\Stmt\Use_::TYPE_NORMAL) {
            foreach ($use->uses as $useUse) {
                if ($useUse->name instanceof \PhpParser\Node\Name\FullyQualified) {
                    $useUse->name = new \PhpParser\Node\Name($useUse->name);
                }
            }
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
        if (\count($stmts) === 1) {
            $onlyStmt = $stmts[0];
            if ($onlyStmt instanceof \Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace) {
                return $onlyStmt->stmts;
            }
        }
        return $stmts;
    }
    /**
     * Solves https://github.com/rectorphp/rector/issues/1964
     *
     * Some files have spaces, some have tabs. Keep the original indent if possible.
     *
     * @param Stmt[] $stmts
     */
    private function detectTabOrSpaceIndentCharacter(array $stmts) : void
    {
        // use space by default
        $this->tabOrSpaceIndentCharacter = ' ';
        foreach ($stmts as $stmt) {
            if (!$stmt instanceof \PhpParser\Node) {
                continue;
            }
            /** @var SmartFileInfo|null $fileInfo */
            $fileInfo = $stmt->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
            if ($fileInfo === null) {
                continue;
            }
            $whitespaces = \count(\RectorPrefix20210119\Nette\Utils\Strings::matchAll($fileInfo->getContents(), self::FOUR_SPACE_START_REGEX));
            $tabs = \count(\RectorPrefix20210119\Nette\Utils\Strings::matchAll($fileInfo->getContents(), '#^\\t#m'));
            // tab vs space
            $this->tabOrSpaceIndentCharacter = ($whitespaces <=> $tabs) >= 0 ? ' ' : "\t";
        }
    }
    /**
     * @param Node[] $nodes
     */
    private function moveCommentsFromAttributeObjectToCommentsAttribute(array $nodes) : void
    {
        // move phpdoc from node to "comment" attribute
        foreach ($nodes as $node) {
            if (!$node instanceof \PhpParser\Node) {
                continue;
            }
            $this->docBlockManipulator->updateNodeWithPhpDocInfo($node);
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
