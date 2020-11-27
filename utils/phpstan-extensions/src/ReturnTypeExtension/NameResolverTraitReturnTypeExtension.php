<?php

declare (strict_types=1);
namespace Rector\PHPStanExtensions\ReturnTypeExtension;

use PHPStan\Reflection\MethodReflection;
use Rector\Core\Rector\AbstractRector;
final class NameResolverTraitReturnTypeExtension extends \Rector\PHPStanExtensions\ReturnTypeExtension\AbstractResolvedNameReturnTypeExtension
{
    /**
     * Original scope @see NameResolverTrait
     */
    public function getClass() : string
    {
        return \Rector\Core\Rector\AbstractRector::class;
    }
    public function isMethodSupported(\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'getName';
    }
}
