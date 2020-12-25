<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Adapter;

use LogicException;
use ReflectionType as CoreReflectionType;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionNamedType as BetterReflectionNamedType;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionType as BetterReflectionType;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionUnionType as BetterReflectionUnionType;
use function get_class;
use function sprintf;
class ReflectionType
{
    private function __construct()
    {
    }
    public static function fromReturnTypeOrNull(?\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionType $betterReflectionType) : ?\ReflectionType
    {
        if ($betterReflectionType === null) {
            return null;
        }
        if ($betterReflectionType instanceof \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionNamedType) {
            return new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Adapter\ReflectionNamedType($betterReflectionType);
        }
        if ($betterReflectionType instanceof \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionUnionType) {
            return new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Adapter\ReflectionUnionType($betterReflectionType);
        }
        throw new \LogicException(\sprintf('%s is not supported.', \get_class($betterReflectionType)));
    }
}
