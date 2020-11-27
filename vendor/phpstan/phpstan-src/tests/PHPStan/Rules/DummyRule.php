<?php

declare (strict_types=1);
namespace PHPStan\Rules;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\FuncCall>
 */
class DummyRule implements \PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return 'PhpParser\\Node\\Expr\\FuncCall';
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        return [];
    }
}
