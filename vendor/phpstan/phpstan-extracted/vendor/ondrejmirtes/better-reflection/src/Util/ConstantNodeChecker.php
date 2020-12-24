<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\InvalidConstantNode;
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
    public static function assertValidDefineFunctionCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $node) : void
    {
        if (!$node->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
            throw \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\InvalidConstantNode::create($node);
        }
        if ($node->name->toLowerString() !== 'define') {
            throw \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\InvalidConstantNode::create($node);
        }
        if (!\in_array(\count($node->args), [2, 3], \true)) {
            throw \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\InvalidConstantNode::create($node);
        }
        if (!$node->args[0]->value instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_) {
            throw \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\InvalidConstantNode::create($node);
        }
        $valueNode = $node->args[1]->value;
        if ($valueNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall) {
            throw \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\InvalidConstantNode::create($node);
        }
        if ($valueNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
            throw \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\InvalidConstantNode::create($node);
        }
    }
}
