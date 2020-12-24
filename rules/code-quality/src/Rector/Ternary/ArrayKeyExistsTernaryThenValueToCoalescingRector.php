<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Ternary;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Coalesce;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Ternary;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/f7itn
 *
 * @see \Rector\CodeQuality\Tests\Rector\Ternary\ArrayKeyExistsTernaryThenValueToCoalescingRector\ArrayKeyExistsTernaryThenValueToCoalescingRectorTest
 */
final class ArrayKeyExistsTernaryThenValueToCoalescingRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change array_key_exists() ternary to coalesing', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run($values, $keyToMatch)
    {
        $result = array_key_exists($keyToMatch, $values) ? $values[$keyToMatch] : null;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run($values, $keyToMatch)
    {
        $result = $values[$keyToMatch] ?? null;
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Ternary::class];
    }
    /**
     * @param Ternary $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if (!$node->cond instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall) {
            return null;
        }
        if (!$this->isName($node->cond, 'array_key_exists')) {
            return null;
        }
        if (!$node->if instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch) {
            return null;
        }
        if (!$this->areArrayKeysExistsArgsMatchingDimFetch($node->cond, $node->if)) {
            return null;
        }
        if (!$this->isNull($node->else)) {
            return null;
        }
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Coalesce($node->if, $node->else);
    }
    /**
     * Equals if:
     *
     * array_key_exists($key, $values);
     * =
     * $values[$key]
     */
    private function areArrayKeysExistsArgsMatchingDimFetch(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $funcCall, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : bool
    {
        $keyExpr = $funcCall->args[0]->value;
        $valuesExpr = $funcCall->args[1]->value;
        if (!$this->areNodesEqual($arrayDimFetch->var, $valuesExpr)) {
            return \false;
        }
        return $this->areNodesEqual($arrayDimFetch->dim, $keyExpr);
    }
}
