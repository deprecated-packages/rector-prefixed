<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodeQuality\Rector\FuncCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\FuncCall\InArrayAndArrayKeysToArrayKeyExistsRector\InArrayAndArrayKeysToArrayKeyExistsRectorTest
 */
final class InArrayAndArrayKeysToArrayKeyExistsRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Simplify `in_array` and `array_keys` functions combination into `array_key_exists` when `array_keys` has one argument only', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('in_array("key", array_keys($array), true);', 'array_key_exists("key", $array);')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isName($node, 'in_array')) {
            return null;
        }
        $secondArgument = $node->args[1]->value;
        if (!$secondArgument instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall) {
            return null;
        }
        if (!$this->isName($secondArgument, 'array_keys')) {
            return null;
        }
        if (\count((array) $secondArgument->args) > 1) {
            return null;
        }
        $keyArg = $node->args[0];
        $arrayArg = $node->args[1];
        /** @var FuncCall $innerFuncCallNode */
        $innerFuncCallNode = $arrayArg->value;
        $arrayArg = $innerFuncCallNode->args[0];
        $node->name = new \_PhpScoper0a6b37af0871\PhpParser\Node\Name('array_key_exists');
        $node->args = [$keyArg, $arrayArg];
        return $node;
    }
}
