<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection\Mixin;

use RectorPrefix20201227\PHPStan\Analyser\OutOfClassScope;
use RectorPrefix20201227\PHPStan\Reflection\ClassReflection;
use RectorPrefix20201227\PHPStan\Reflection\PropertiesClassReflectionExtension;
use RectorPrefix20201227\PHPStan\Reflection\PropertyReflection;
use PHPStan\Type\TypeUtils;
class MixinPropertiesClassReflectionExtension implements \RectorPrefix20201227\PHPStan\Reflection\PropertiesClassReflectionExtension
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
    public function hasProperty(\RectorPrefix20201227\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : bool
    {
        return $this->findProperty($classReflection, $propertyName) !== null;
    }
    public function getProperty(\RectorPrefix20201227\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : \RectorPrefix20201227\PHPStan\Reflection\PropertyReflection
    {
        $property = $this->findProperty($classReflection, $propertyName);
        if ($property === null) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        return $property;
    }
    private function findProperty(\RectorPrefix20201227\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : ?\RectorPrefix20201227\PHPStan\Reflection\PropertyReflection
    {
        $mixinTypes = $classReflection->getResolvedMixinTypes();
        foreach ($mixinTypes as $type) {
            if (\count(\array_intersect(\PHPStan\Type\TypeUtils::getDirectClassNames($type), $this->mixinExcludeClasses)) > 0) {
                continue;
            }
            if (!$type->hasProperty($propertyName)->yes()) {
                continue;
            }
            return $type->getProperty($propertyName, new \RectorPrefix20201227\PHPStan\Analyser\OutOfClassScope());
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
