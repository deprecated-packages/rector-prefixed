<?php

declare (strict_types=1);
namespace Rector\PHPStanExtensions\NodeAnalyzer;

use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Type\TypeWithClassName;
use Symplify\PHPStanRules\Naming\SimpleNameResolver;
final class TypeAndNameAnalyzer
{
    /**
     * @var SimpleNameResolver
     */
    private $simpleNameResolver;
    public function __construct(\Symplify\PHPStanRules\Naming\SimpleNameResolver $simpleNameResolver)
    {
        $this->simpleNameResolver = $simpleNameResolver;
    }
    public function isMethodCallTypeAndName(\PhpParser\Node\Expr\MethodCall $methodCall, \PHPStan\Analyser\Scope $scope, string $desiredClassType, string $desiredMethodName) : bool
    {
        $callerType = $scope->getType($methodCall->var);
        if (!$callerType instanceof \PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        if (!\is_a($callerType->getClassName(), $desiredClassType, \true)) {
            return \false;
        }
        return $this->simpleNameResolver->isName($methodCall->name, $desiredMethodName);
    }
}
