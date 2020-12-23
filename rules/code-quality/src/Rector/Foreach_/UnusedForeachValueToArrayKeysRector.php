<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CodeQuality\Rector\Foreach_;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Foreach_;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Foreach_\UnusedForeachValueToArrayKeysRector\UnusedForeachValueToArrayKeysRectorTest
 */
final class UnusedForeachValueToArrayKeysRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change foreach with unused $value but only $key, to array_keys()', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $items = [];
        foreach ($values as $key => $value) {
            $items[$key] = null;
        }
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $items = [];
        foreach (array_keys($values) as $key) {
            $items[$key] = null;
        }
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Foreach_::class];
    }
    /**
     * @param Foreach_ $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if ($node->keyVar === null) {
            return null;
        }
        // special case of nested array items
        if ($node->valueVar instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_) {
            $node->valueVar = $this->refactorArrayForeachValue($node->valueVar, $node);
            if ($node->valueVar->items !== []) {
                return null;
            }
        } elseif ($node->valueVar instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable) {
            if ($this->isVariableUsedInForeach($node->valueVar, $node)) {
                return null;
            }
        } else {
            return null;
        }
        if (\is_a($this->getStaticType($node->expr), \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType::class)) {
            return null;
        }
        $this->removeForeachValueAndUseArrayKeys($node);
        return $node;
    }
    private function refactorArrayForeachValue(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_ $array, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Foreach_ $foreach) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_
    {
        foreach ($array->items as $key => $arrayItem) {
            if (!$arrayItem instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem) {
                continue;
            }
            $value = $arrayItem->value;
            if (!$value instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable) {
                return $array;
            }
            if ($this->isVariableUsedInForeach($value, $foreach)) {
                continue;
            }
            unset($array->items[$key]);
        }
        return $array;
    }
    private function isVariableUsedInForeach(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable $variable, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Foreach_ $foreach) : bool
    {
        return (bool) $this->betterNodeFinder->findFirst($foreach->stmts, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) use($variable) : bool {
            return $this->areNodesEqual($node, $variable);
        });
    }
    private function removeForeachValueAndUseArrayKeys(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Foreach_ $foreach) : void
    {
        // remove key value
        $foreach->valueVar = $foreach->keyVar;
        $foreach->keyVar = null;
        $foreach->expr = $this->createFuncCall('array_keys', [$foreach->expr]);
    }
}
