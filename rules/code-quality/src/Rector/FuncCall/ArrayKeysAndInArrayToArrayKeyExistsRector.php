<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodeQuality\Rector\FuncCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\FuncCall\ArrayKeysAndInArrayToArrayKeyExistsRector\ArrayKeysAndInArrayToArrayKeyExistsRectorTest
 */
final class ArrayKeysAndInArrayToArrayKeyExistsRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replace array_keys() and in_array() to array_key_exists()', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run($packageName, $values)
    {
        $keys = array_keys($values);
        return in_array($packageName, $keys, true);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run($packageName, $values)
    {
        return array_key_exists($packageName, $values);
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isFuncCallName($node, 'in_array')) {
            return null;
        }
        $arrayVariable = $node->args[1]->value;
        /** @var Assign|Node|null $previousAssignArraysKeysFuncCall */
        $previousAssignArraysKeysFuncCall = $this->betterNodeFinder->findFirstPrevious($node, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($arrayVariable) : bool {
            // breaking out of scope
            if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike) {
                return \true;
            }
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
                return \false;
            }
            if (!$this->areNodesEqual($arrayVariable, $node->var)) {
                return \false;
            }
            return $this->isFuncCallName($node->expr, 'array_keys');
        });
        if (!$previousAssignArraysKeysFuncCall instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
            return null;
        }
        /** @var FuncCall $arrayKeysFuncCall */
        $arrayKeysFuncCall = $previousAssignArraysKeysFuncCall->expr;
        $this->removeNode($previousAssignArraysKeysFuncCall);
        return $this->createArrayKeyExists($node, $arrayKeysFuncCall);
    }
    private function createArrayKeyExists(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $inArrayFuncCall, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $arrayKeysFuncCall) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall
    {
        $arguments = [$inArrayFuncCall->args[0], $arrayKeysFuncCall->args[0]];
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name('array_key_exists'), $arguments);
    }
}
