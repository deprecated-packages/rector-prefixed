<?php

declare (strict_types=1);
namespace PHPStan\Analyser;

use PhpParser\Node;
use PHPStan\Rules\Rule;
class EvaluationOrderRule implements \PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \PhpParser\Node::class;
    }
    /**
     * @param Node $node
     * @param Scope $scope
     * @return string[]
     */
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if ($node instanceof \PhpParser\Node\Expr\FuncCall && $node->name instanceof \PhpParser\Node\Name) {
            return [$node->name->toString()];
        }
        if ($node instanceof \PhpParser\Node\Scalar\String_) {
            return [$node->value];
        }
        return [];
    }
}
