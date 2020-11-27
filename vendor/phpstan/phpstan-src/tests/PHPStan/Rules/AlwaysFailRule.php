<?php

declare (strict_types=1);
namespace PHPStan\Rules;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\FuncCall>
 */
class AlwaysFailRule implements \PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\FuncCall::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->name instanceof \PhpParser\Node\Name) {
            return [];
        }
        if ($node->name->toLowerString() !== 'fail') {
            return [];
        }
        return ['Fail.'];
    }
}
