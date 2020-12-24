<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Reflection;

use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider;
final class ClassReflectionTypesResolver
{
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    /**
     * Warning: Includes original class as well to normalize all types to strings!
     *
     * @return string[]
     */
    public function resolve(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $classReflection) : array
    {
        // current class
        $types = [$classReflection->getName()];
        // parent classes
        $types = \array_merge($types, $classReflection->getParentClassesNames());
        // interfaces
        foreach ($classReflection->getInterfaces() as $interfaceReflection) {
            $types[] = $interfaceReflection->getName();
        }
        foreach ($classReflection->getInterfaces() as $interfaceReflection) {
            $types[] = $interfaceReflection->getName();
        }
        // traits
        foreach ($classReflection->getTraits() as $traitReflection) {
            $types[] = $traitReflection->getName();
        }
        // to cover traits of parent classes
        foreach ($classReflection->getParentClassesNames() as $parentClassName) {
            $parentClassReflection = $this->reflectionProvider->getClass($parentClassName);
            foreach ($parentClassReflection->getTraits() as $parentClassTrait) {
                $types[] = $parentClassTrait->getName();
            }
        }
        return \array_unique($types);
    }
}
