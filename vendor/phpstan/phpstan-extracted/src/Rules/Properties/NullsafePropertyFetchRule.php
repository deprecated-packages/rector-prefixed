<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Properties;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Rules\Rule;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a6b37af0871\PHPStan\Type\NullType;
use _PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel;
/**
 * @implements Rule<Node\Expr\NullsafePropertyFetch>
 */
class NullsafePropertyFetchRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\NullsafePropertyFetch::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        $nullType = new \_PhpScoper0a6b37af0871\PHPStan\Type\NullType();
        $calledOnType = $scope->getType($node->var);
        if ($calledOnType->equals($nullType)) {
            return [];
        }
        if (!$calledOnType->isSuperTypeOf($nullType)->no()) {
            return [];
        }
        return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Using nullsafe property access on non-nullable type %s. Use -> instead.', $calledOnType->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
    }
}
