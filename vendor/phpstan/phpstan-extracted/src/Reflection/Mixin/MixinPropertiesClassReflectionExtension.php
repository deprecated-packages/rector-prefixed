<?php

declare (strict_types=1);
namespace PHPStan\Reflection\Mixin;

use PHPStan\Analyser\OutOfClassScope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\PropertiesClassReflectionExtension;
use PHPStan\Reflection\PropertyReflection;
use PHPStan\Type\TypeUtils;
class MixinPropertiesClassReflectionExtension implements \PHPStan\Reflection\PropertiesClassReflectionExtension
{
    /** @var string[] */
    private $mixinExcludeClasses;
    /**
     * @param string[] $mixinExcludeClasses
     */
    public function __construct(array $mixinExcludeClasses)
    {
        $this->mixinExcludeClasses = $mixinExcludeClasses;
    }
    public function hasProperty(\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : bool
    {
        return $this->findProperty($classReflection, $propertyName) !== null;
    }
    public function getProperty(\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : \PHPStan\Reflection\PropertyReflection
    {
        $property = $this->findProperty($classReflection, $propertyName);
        if ($property === null) {
            throw new \PHPStan\ShouldNotHappenException();
        }
        return $property;
    }
    private function findProperty(\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : ?\PHPStan\Reflection\PropertyReflection
    {
        $mixinTypes = $classReflection->getResolvedMixinTypes();
        foreach ($mixinTypes as $type) {
            if (\count(\array_intersect(\PHPStan\Type\TypeUtils::getDirectClassNames($type), $this->mixinExcludeClasses)) > 0) {
                continue;
            }
            if (!$type->hasProperty($propertyName)->yes()) {
                continue;
            }
            return $type->getProperty($propertyName, new \PHPStan\Analyser\OutOfClassScope());
        }
        foreach ($classReflection->getParents() as $parentClass) {
            $property = $this->findProperty($parentClass, $propertyName);
            if ($property === null) {
                continue;
            }
            return $property;
        }
        return null;
    }
}
