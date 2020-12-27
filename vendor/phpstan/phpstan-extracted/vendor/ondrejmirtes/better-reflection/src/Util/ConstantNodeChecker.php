<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\BetterReflection\Util;

use PhpParser\Node;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\InvalidConstantNode;
use function count;
use function in_array;
/**
 * @internal
 */
final class ConstantNodeChecker
{
    /**
     * @throws InvalidConstantNode
     */
    public static function assertValidDefineFunctionCall(\PhpParser\Node\Expr\FuncCall $node) : void
    {
        if (!$node->name instanceof \PhpParser\Node\Name) {
            throw \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\InvalidConstantNode::create($node);
        }
        if ($node->name->toLowerString() !== 'define') {
            throw \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\InvalidConstantNode::create($node);
        }
        if (!\in_array(\count($node->args), [2, 3], \true)) {
            throw \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\InvalidConstantNode::create($node);
        }
        if (!$node->args[0]->value instanceof \PhpParser\Node\Scalar\String_) {
            throw \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\InvalidConstantNode::create($node);
        }
        $valueNode = $node->args[1]->value;
        if ($valueNode instanceof \PhpParser\Node\Expr\FuncCall) {
            throw \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\InvalidConstantNode::create($node);
        }
        if ($valueNode instanceof \PhpParser\Node\Expr\Variable) {
            throw \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\InvalidConstantNode::create($node);
        }
    }
}
