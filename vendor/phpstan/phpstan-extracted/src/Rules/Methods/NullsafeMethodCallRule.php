<?php

declare (strict_types=1);
namespace PHPStan\Rules\Methods;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\NullType;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements Rule<Node\Expr\NullsafeMethodCall>
 */
class NullsafeMethodCallRule implements \PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\NullsafeMethodCall::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        $nullType = new \PHPStan\Type\NullType();
        $calledOnType = $scope->getType($node->var);
        if ($calledOnType->equals($nullType)) {
            return [];
        }
        if (!$calledOnType->isSuperTypeOf($nullType)->no()) {
            return [];
        }
        return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Using nullsafe method call on non-nullable type %s. Use -> instead.', $calledOnType->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
    }
}
