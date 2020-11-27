<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\Adapter;

use ReflectionNamedType as CoreReflectionNamedType;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\ReflectionNamedType as BetterReflectionType;
use function ltrim;
class ReflectionNamedType extends \ReflectionNamedType
{
    /** @var BetterReflectionType */
    private $betterReflectionType;
    public function __construct(\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\ReflectionNamedType $betterReflectionType)
    {
        $this->betterReflectionType = $betterReflectionType;
    }
    public function getName() : string
    {
        return $this->betterReflectionType->getName();
    }
    public function __toString() : string
    {
        return $this->betterReflectionType->__toString();
    }
    public function allowsNull() : bool
    {
        return $this->betterReflectionType->allowsNull();
    }
    public function isBuiltin() : bool
    {
        $type = \ltrim((string) $this->betterReflectionType, '?');
        if ($type === 'self' || $type === 'parent') {
            return \false;
        }
        return $this->betterReflectionType->isBuiltin();
    }
}
