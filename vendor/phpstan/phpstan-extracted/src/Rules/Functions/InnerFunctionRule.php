<?php

declare (strict_types=1);
namespace PHPStan\Rules\Functions;

use PhpParser\Node;
use PhpParser\Node\Stmt\Function_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Function_>
 */
class InnerFunctionRule implements \PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \PhpParser\Node\Stmt\Function_::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if ($scope->getFunction() === null) {
            return [];
        }
        return [\PHPStan\Rules\RuleErrorBuilder::message('Inner named functions are not supported by PHPStan. Consider refactoring to an anonymous function, class method, or a top-level-defined function. See issue #165 (https://github.com/phpstan/phpstan/issues/165) for more details.')->build()];
    }
}
