<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php70\Rector\FuncCall;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Ternary;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\Php70\EregToPcreTransformer;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see http://php.net/reference.pcre.pattern.posix
 * @see https://stackoverflow.com/a/17033826/1348344
 * @see https://docstore.mik.ua/orelly/webprog/pcook/ch13_02.htm
 *
 * @see \Rector\Php70\Tests\Rector\FuncCall\EregToPregMatchRector\EregToPregMatchRectorTest
 */
final class EregToPregMatchRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private const OLD_NAMES_TO_NEW_ONES = ['ereg' => 'preg_match', 'eregi' => 'preg_match', 'ereg_replace' => 'preg_replace', 'eregi_replace' => 'preg_replace', 'split' => 'preg_split', 'spliti' => 'preg_split'];
    /**
     * @var EregToPcreTransformer
     */
    private $eregToPcreTransformer;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Php70\EregToPcreTransformer $eregToPcreTransformer)
    {
        $this->eregToPcreTransformer = $eregToPcreTransformer;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes ereg*() to preg*() calls', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('ereg("hi")', 'preg_match("#hi#");')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $functionName = $this->getName($node);
        if ($functionName === null) {
            return null;
        }
        if (!isset(self::OLD_NAMES_TO_NEW_ONES[$functionName])) {
            return null;
        }
        $patternNode = $node->args[0]->value;
        if ($patternNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_) {
            $this->processStringPattern($node, $patternNode, $functionName);
        } elseif ($patternNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
            $this->processVariablePattern($node, $patternNode, $functionName);
        }
        $this->processSplitLimitArgument($node, $functionName);
        $node->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name(self::OLD_NAMES_TO_NEW_ONES[$functionName]);
        // ereg|eregi 3rd argument return value fix
        if (\in_array($functionName, ['ereg', 'eregi'], \true) && isset($node->args[2])) {
            $parentNode = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
                return $this->createTernaryWithStrlenOfFirstMatch($node);
            }
        }
        return $node;
    }
    private function processStringPattern(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $funcCall, \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_ $string, string $functionName) : void
    {
        $pattern = $string->value;
        $pattern = $this->eregToPcreTransformer->transform($pattern, $this->isCaseInsensitiveFunction($functionName));
        $funcCall->args[0]->value = new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_($pattern);
    }
    private function processVariablePattern(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $funcCall, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable $variable, string $functionName) : void
    {
        $pregQuotePatternNode = $this->createFuncCall('preg_quote', [new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg($variable), new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg(new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_('#'))]);
        $startConcat = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Concat(new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_('#'), $pregQuotePatternNode);
        $endDelimiter = $this->isCaseInsensitiveFunction($functionName) ? '#mi' : '#m';
        $concat = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Concat($startConcat, new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_($endDelimiter));
        $funcCall->args[0]->value = $concat;
    }
    /**
     * Equivalent of:
     * split(' ', 'hey Tom', 0);
     * ↓
     * preg_split('# #', 'hey Tom', 1);
     */
    private function processSplitLimitArgument(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $funcCall, string $functionName) : void
    {
        if (!\_PhpScoperb75b35f52b74\Nette\Utils\Strings::startsWith($functionName, 'split')) {
            return;
        }
        // 3rd argument - $limit, 0 → 1
        if (!isset($funcCall->args[2])) {
            return;
        }
        if (!$funcCall->args[2]->value instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber) {
            return;
        }
        /** @var LNumber $limitNumberNode */
        $limitNumberNode = $funcCall->args[2]->value;
        if ($limitNumberNode->value !== 0) {
            return;
        }
        $limitNumberNode->value = 1;
    }
    private function createTernaryWithStrlenOfFirstMatch(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $funcCall) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Ternary
    {
        $arrayDimFetch = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch($funcCall->args[2]->value, new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber(0));
        $strlenFuncCall = $this->createFuncCall('strlen', [$arrayDimFetch]);
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Ternary($funcCall, $strlenFuncCall, $this->createFalse());
    }
    private function isCaseInsensitiveFunction(string $functionName) : bool
    {
        if (\_PhpScoperb75b35f52b74\Nette\Utils\Strings::contains($functionName, 'eregi')) {
            return \true;
        }
        return \_PhpScoperb75b35f52b74\Nette\Utils\Strings::contains($functionName, 'spliti');
    }
}
