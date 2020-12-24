<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Properties;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Rule;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\NullType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel;
/**
 * @implements Rule<Node\Expr\NullsafePropertyFetch>
 */
class NullsafePropertyFetchRule implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\NullsafePropertyFetch::class;
    }
    public function processNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : array
    {
        $nullType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\NullType();
        $calledOnType = $scope->getType($node->var);
        if ($calledOnType->equals($nullType)) {
            return [];
        }
        if (!$calledOnType->isSuperTypeOf($nullType)->no()) {
            return [];
        }
        return [\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Using nullsafe property access on non-nullable type %s. Use -> instead.', $calledOnType->describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
    }
}
