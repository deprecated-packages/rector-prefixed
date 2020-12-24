<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection\Annotations;

use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\PropertiesClassReflectionExtension;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeHelper;
class AnnotationsPropertiesClassReflectionExtension implements \_PhpScoperb75b35f52b74\PHPStan\Reflection\PropertiesClassReflectionExtension
{
    /** @var \PHPStan\Reflection\PropertyReflection[][] */
    private $properties = [];
    public function hasProperty(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : bool
    {
        if (!isset($this->properties[$classReflection->getCacheKey()])) {
            $this->properties[$classReflection->getCacheKey()] = $this->createProperties($classReflection, $classReflection);
        }
        return isset($this->properties[$classReflection->getCacheKey()][$propertyName]);
    }
    public function getProperty(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection
    {
        return $this->properties[$classReflection->getCacheKey()][$propertyName];
    }
    /**
     * @param \PHPStan\Reflection\ClassReflection $classReflection
     * @param \PHPStan\Reflection\ClassReflection $declaringClass
     * @return \PHPStan\Reflection\PropertyReflection[]
     */
    private function createProperties(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $classReflection, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $declaringClass) : array
    {
        $properties = [];
        foreach ($classReflection->getTraits() as $traitClass) {
            $properties += $this->createProperties($traitClass, $classReflection);
        }
        foreach ($classReflection->getParents() as $parentClass) {
            $properties += $this->createProperties($parentClass, $parentClass);
            foreach ($parentClass->getTraits() as $traitClass) {
                $properties += $this->createProperties($traitClass, $parentClass);
            }
        }
        foreach ($classReflection->getInterfaces() as $interfaceClass) {
            $properties += $this->createProperties($interfaceClass, $interfaceClass);
        }
        $fileName = $classReflection->getFileName();
        if ($fileName === \false) {
            return $properties;
        }
        $propertyTags = $classReflection->getPropertyTags();
        foreach ($propertyTags as $propertyName => $propertyTag) {
            $properties[$propertyName] = new \_PhpScoperb75b35f52b74\PHPStan\Reflection\Annotations\AnnotationPropertyReflection($declaringClass, \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeHelper::resolveTemplateTypes($propertyTag->getType(), $classReflection->getActiveTemplateTypeMap()), $propertyTag->isReadable(), $propertyTag->isWritable());
        }
        return $properties;
    }
}
