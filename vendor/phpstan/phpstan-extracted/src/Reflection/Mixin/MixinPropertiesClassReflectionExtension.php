<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection\Mixin;

use _PhpScoperb75b35f52b74\PHPStan\Analyser\OutOfClassScope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\PropertiesClassReflectionExtension;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils;
class MixinPropertiesClassReflectionExtension implements \_PhpScoperb75b35f52b74\PHPStan\Reflection\PropertiesClassReflectionExtension
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
    public function hasProperty(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : bool
    {
        return $this->findProperty($classReflection, $propertyName) !== null;
    }
    public function getProperty(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection
    {
        $property = $this->findProperty($classReflection, $propertyName);
        if ($property === null) {
            throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
        }
        return $property;
    }
    private function findProperty(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : ?\_PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection
    {
        $mixinTypes = $classReflection->getResolvedMixinTypes();
        foreach ($mixinTypes as $type) {
            if (\count(\array_intersect(\_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::getDirectClassNames($type), $this->mixinExcludeClasses)) > 0) {
                continue;
            }
            if (!$type->hasProperty($propertyName)->yes()) {
                continue;
            }
            return $type->getProperty($propertyName, new \_PhpScoperb75b35f52b74\PHPStan\Analyser\OutOfClassScope());
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
