<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Reflection\Annotations;

use _PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\MethodsClassReflectionExtension;
use _PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeHelper;
class AnnotationsMethodsClassReflectionExtension implements \_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodsClassReflectionExtension
{
    /** @var MethodReflection[][] */
    private $methods = [];
    public function hasMethod(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : bool
    {
        if (!isset($this->methods[$classReflection->getCacheKey()])) {
            $this->methods[$classReflection->getCacheKey()] = $this->createMethods($classReflection, $classReflection);
        }
        return isset($this->methods[$classReflection->getCacheKey()][$methodName]);
    }
    public function getMethod(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : \_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection
    {
        return $this->methods[$classReflection->getCacheKey()][$methodName];
    }
    /**
     * @param ClassReflection $classReflection
     * @param ClassReflection $declaringClass
     * @return MethodReflection[]
     */
    private function createMethods(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflection $classReflection, \_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflection $declaringClass) : array
    {
        $methods = [];
        foreach ($classReflection->getTraits() as $traitClass) {
            $methods += $this->createMethods($traitClass, $classReflection);
        }
        foreach ($classReflection->getParents() as $parentClass) {
            $methods += $this->createMethods($parentClass, $parentClass);
            foreach ($parentClass->getTraits() as $traitClass) {
                $methods += $this->createMethods($traitClass, $parentClass);
            }
        }
        foreach ($classReflection->getInterfaces() as $interfaceClass) {
            $methods += $this->createMethods($interfaceClass, $interfaceClass);
        }
        $fileName = $classReflection->getFileName();
        if ($fileName === \false) {
            return $methods;
        }
        $methodTags = $classReflection->getMethodTags();
        foreach ($methodTags as $methodName => $methodTag) {
            $parameters = [];
            foreach ($methodTag->getParameters() as $parameterName => $parameterTag) {
                $parameters[] = new \_PhpScoper0a6b37af0871\PHPStan\Reflection\Annotations\AnnotationsMethodParameterReflection($parameterName, $parameterTag->getType(), $parameterTag->passedByReference(), $parameterTag->isOptional(), $parameterTag->isVariadic(), $parameterTag->getDefaultValue());
            }
            $methods[$methodName] = new \_PhpScoper0a6b37af0871\PHPStan\Reflection\Annotations\AnnotationMethodReflection($methodName, $declaringClass, \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeHelper::resolveTemplateTypes($methodTag->getReturnType(), $classReflection->getActiveTemplateTypeMap()), $parameters, $methodTag->isStatic(), $this->detectMethodVariadic($parameters));
        }
        return $methods;
    }
    /**
     * @param AnnotationsMethodParameterReflection[] $parameters
     * @return bool
     */
    private function detectMethodVariadic(array $parameters) : bool
    {
        if ($parameters === []) {
            return \false;
        }
        $possibleVariadicParameterIndex = \count($parameters) - 1;
        $possibleVariadicParameter = $parameters[$possibleVariadicParameterIndex];
        return $possibleVariadicParameter->isVariadic();
    }
}
