<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Reflection\Mixin;

use _PhpScoper0a6b37af0871\PHPStan\Analyser\OutOfClassScope;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\PropertiesClassReflectionExtension;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\PropertyReflection;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils;
class MixinPropertiesClassReflectionExtension implements \_PhpScoper0a6b37af0871\PHPStan\Reflection\PropertiesClassReflectionExtension
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
    public function hasProperty(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : bool
    {
        return $this->findProperty($classReflection, $propertyName) !== null;
    }
    public function getProperty(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : \_PhpScoper0a6b37af0871\PHPStan\Reflection\PropertyReflection
    {
        $property = $this->findProperty($classReflection, $propertyName);
        if ($property === null) {
            throw new \_PhpScoper0a6b37af0871\PHPStan\ShouldNotHappenException();
        }
        return $property;
    }
    private function findProperty(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : ?\_PhpScoper0a6b37af0871\PHPStan\Reflection\PropertyReflection
    {
        $mixinTypes = $classReflection->getResolvedMixinTypes();
        foreach ($mixinTypes as $type) {
            if (\count(\array_intersect(\_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::getDirectClassNames($type), $this->mixinExcludeClasses)) > 0) {
                continue;
            }
            if (!$type->hasProperty($propertyName)->yes()) {
                continue;
            }
            return $type->getProperty($propertyName, new \_PhpScoper0a6b37af0871\PHPStan\Analyser\OutOfClassScope());
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
