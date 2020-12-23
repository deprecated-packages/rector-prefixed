<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Php70\Rector\FuncCall;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Arg;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Ternary;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\LNumber;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Rector\Php70\EregToPcreTransformer;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see http://php.net/reference.pcre.pattern.posix
 * @see https://stackoverflow.com/a/17033826/1348344
 * @see https://docstore.mik.ua/orelly/webprog/pcook/ch13_02.htm
 *
 * @see \Rector\Php70\Tests\Rector\FuncCall\EregToPregMatchRector\EregToPregMatchRectorTest
 */
final class EregToPregMatchRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private const OLD_NAMES_TO_NEW_ONES = ['ereg' => 'preg_match', 'eregi' => 'preg_match', 'ereg_replace' => 'preg_replace', 'eregi_replace' => 'preg_replace', 'split' => 'preg_split', 'spliti' => 'preg_split'];
    /**
     * @var EregToPcreTransformer
     */
    private $eregToPcreTransformer;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Php70\EregToPcreTransformer $eregToPcreTransformer)
    {
        $this->eregToPcreTransformer = $eregToPcreTransformer;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes ereg*() to preg*() calls', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('ereg("hi")', 'preg_match("#hi#");')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $functionName = $this->getName($node);
        if ($functionName === null) {
            return null;
        }
        if (!isset(self::OLD_NAMES_TO_NEW_ONES[$functionName])) {
            return null;
        }
        $patternNode = $node->args[0]->value;
        if ($patternNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_) {
            $this->processStringPattern($node, $patternNode, $functionName);
        } elseif ($patternNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable) {
            $this->processVariablePattern($node, $patternNode, $functionName);
        }
        $this->processSplitLimitArgument($node, $functionName);
        $node->name = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name(self::OLD_NAMES_TO_NEW_ONES[$functionName]);
        // ereg|eregi 3rd argument return value fix
        if (\in_array($functionName, ['ereg', 'eregi'], \true) && isset($node->args[2])) {
            $parentNode = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
                return $this->createTernaryWithStrlenOfFirstMatch($node);
            }
        }
        return $node;
    }
    private function processStringPattern(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall $funcCall, \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_ $string, string $functionName) : void
    {
        $pattern = $string->value;
        $pattern = $this->eregToPcreTransformer->transform($pattern, $this->isCaseInsensitiveFunction($functionName));
        $funcCall->args[0]->value = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_($pattern);
    }
    private function processVariablePattern(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall $funcCall, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable $variable, string $functionName) : void
    {
        $pregQuotePatternNode = $this->createFuncCall('preg_quote', [new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg($variable), new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_('#'))]);
        $startConcat = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_('#'), $pregQuotePatternNode);
        $endDelimiter = $this->isCaseInsensitiveFunction($functionName) ? '#mi' : '#m';
        $concat = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat($startConcat, new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_($endDelimiter));
        $funcCall->args[0]->value = $concat;
    }
    /**
     * Equivalent of:
     * split(' ', 'hey Tom', 0);
     * ↓
     * preg_split('# #', 'hey Tom', 1);
     */
    private function processSplitLimitArgument(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall $funcCall, string $functionName) : void
    {
        if (!\_PhpScoper0a2ac50786fa\Nette\Utils\Strings::startsWith($functionName, 'split')) {
            return;
        }
        // 3rd argument - $limit, 0 → 1
        if (!isset($funcCall->args[2])) {
            return;
        }
        if (!$funcCall->args[2]->value instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\LNumber) {
            return;
        }
        /** @var LNumber $limitNumberNode */
        $limitNumberNode = $funcCall->args[2]->value;
        if ($limitNumberNode->value !== 0) {
            return;
        }
        $limitNumberNode->value = 1;
    }
    private function createTernaryWithStrlenOfFirstMatch(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall $funcCall) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Ternary
    {
        $arrayDimFetch = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch($funcCall->args[2]->value, new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\LNumber(0));
        $strlenFuncCall = $this->createFuncCall('strlen', [$arrayDimFetch]);
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Ternary($funcCall, $strlenFuncCall, $this->createFalse());
    }
    private function isCaseInsensitiveFunction(string $functionName) : bool
    {
        if (\_PhpScoper0a2ac50786fa\Nette\Utils\Strings::contains($functionName, 'eregi')) {
            return \true;
        }
        return \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::contains($functionName, 'spliti');
    }
}
