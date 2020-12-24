<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\Mixin;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\OutOfClassScope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PropertiesClassReflectionExtension;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PropertyReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeUtils;
class MixinPropertiesClassReflectionExtension implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PropertiesClassReflectionExtension
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
    public function hasProperty(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : bool
    {
        return $this->findProperty($classReflection, $propertyName) !== null;
    }
    public function getProperty(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PropertyReflection
    {
        $property = $this->findProperty($classReflection, $propertyName);
        if ($property === null) {
            throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\ShouldNotHappenException();
        }
        return $property;
    }
    private function findProperty(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PropertyReflection
    {
        $mixinTypes = $classReflection->getResolvedMixinTypes();
        foreach ($mixinTypes as $type) {
            if (\count(\array_intersect(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeUtils::getDirectClassNames($type), $this->mixinExcludeClasses)) > 0) {
                continue;
            }
            if (!$type->hasProperty($propertyName)->yes()) {
                continue;
            }
            return $type->getProperty($propertyName, new \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\OutOfClassScope());
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
