<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection\Mixin;

use _PhpScopere8e811afab72\PHPStan\Analyser\OutOfClassScope;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\PropertiesClassReflectionExtension;
use _PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection;
use _PhpScopere8e811afab72\PHPStan\Type\TypeUtils;
class MixinPropertiesClassReflectionExtension implements \_PhpScopere8e811afab72\PHPStan\Reflection\PropertiesClassReflectionExtension
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
    public function hasProperty(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : bool
    {
        return $this->findProperty($classReflection, $propertyName) !== null;
    }
    public function getProperty(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : \_PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection
    {
        $property = $this->findProperty($classReflection, $propertyName);
        if ($property === null) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        return $property;
    }
    private function findProperty(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : ?\_PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection
    {
        $mixinTypes = $classReflection->getResolvedMixinTypes();
        foreach ($mixinTypes as $type) {
            if (\count(\array_intersect(\_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::getDirectClassNames($type), $this->mixinExcludeClasses)) > 0) {
                continue;
            }
            if (!$type->hasProperty($propertyName)->yes()) {
                continue;
            }
            return $type->getProperty($propertyName, new \_PhpScopere8e811afab72\PHPStan\Analyser\OutOfClassScope());
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
