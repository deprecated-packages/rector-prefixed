<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Roave\BetterReflection\Reflection\Adapter;

use ReflectionUnionType as CoreReflectionUnionType;
use _PhpScoper006a73f0e455\Roave\BetterReflection\Reflection\ReflectionUnionType as BetterReflectionType;
use function array_map;
class ReflectionUnionType extends \ReflectionUnionType
{
    /** @var BetterReflectionType */
    private $betterReflectionType;
    public function __construct(\_PhpScoper006a73f0e455\Roave\BetterReflection\Reflection\ReflectionUnionType $betterReflectionType)
    {
        $this->betterReflectionType = $betterReflectionType;
    }
    public function __toString() : string
    {
        return $this->betterReflectionType->__toString();
    }
    public function allowsNull() : bool
    {
        return $this->betterReflectionType->allowsNull();
    }
    /**
     * @return \ReflectionType[]
     */
    public function getTypes() : array
    {
        return \array_map(static function (\_PhpScoper006a73f0e455\Roave\BetterReflection\Reflection\ReflectionType $type) : \ReflectionType {
            return \_PhpScoper006a73f0e455\Roave\BetterReflection\Reflection\Adapter\ReflectionType::fromReturnTypeOrNull($type);
        }, $this->betterReflectionType->getTypes());
    }
}
