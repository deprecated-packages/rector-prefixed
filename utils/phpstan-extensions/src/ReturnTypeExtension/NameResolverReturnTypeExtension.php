<?php

declare (strict_types=1);
namespace Rector\PHPStanExtensions\ReturnTypeExtension;

use PHPStan\Reflection\MethodReflection;
use Rector\NodeNameResolver\NodeNameResolver;
final class NameResolverReturnTypeExtension extends \Rector\PHPStanExtensions\ReturnTypeExtension\AbstractResolvedNameReturnTypeExtension
{
    public function getClass() : string
    {
        return \Rector\NodeNameResolver\NodeNameResolver::class;
    }
    public function isMethodSupported(\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'getName';
    }
}
