<?php

declare (strict_types=1);
namespace Rector\PHPUnit\NodeManipulator;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
final class ArgumentMover
{
    /**
     * @param MethodCall|StaticCall $node
     * @return void
     */
    public function removeFirst(\PhpParser\Node $node)
    {
        $methodArguments = $node->args;
        \array_shift($methodArguments);
        $node->args = $methodArguments;
    }
}
