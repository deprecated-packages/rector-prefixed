<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflection\Adapter;

use LogicException;
use ReflectionType as CoreReflectionType;
use _PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflection\ReflectionNamedType as BetterReflectionNamedType;
use _PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflection\ReflectionType as BetterReflectionType;
use _PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflection\ReflectionUnionType as BetterReflectionUnionType;
use function get_class;
use function sprintf;
class ReflectionType
{
    private function __construct()
    {
    }
    public static function fromReturnTypeOrNull(?\_PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflection\ReflectionType $betterReflectionType) : ?\ReflectionType
    {
        if ($betterReflectionType === null) {
            return null;
        }
        if ($betterReflectionType instanceof \_PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflection\ReflectionNamedType) {
            return new \_PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflection\Adapter\ReflectionNamedType($betterReflectionType);
        }
        if ($betterReflectionType instanceof \_PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflection\ReflectionUnionType) {
            return new \_PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflection\Adapter\ReflectionUnionType($betterReflectionType);
        }
        throw new \LogicException(\sprintf('%s is not supported.', \get_class($betterReflectionType)));
    }
}
