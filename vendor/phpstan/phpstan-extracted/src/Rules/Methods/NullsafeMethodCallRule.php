<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Methods;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Rules\Rule;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\NullType;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements Rule<Node\Expr\NullsafeMethodCall>
 */
class NullsafeMethodCallRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\NullsafeMethodCall::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        $nullType = new \PHPStan\Type\NullType();
        $calledOnType = $scope->getType($node->var);
        if ($calledOnType->equals($nullType)) {
            return [];
        }
        if (!$calledOnType->isSuperTypeOf($nullType)->no()) {
            return [];
        }
        return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Using nullsafe method call on non-nullable type %s. Use -> instead.', $calledOnType->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
    }
}
