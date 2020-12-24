<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection\Mixin;

use _PhpScopere8e811afab72\PHPStan\Analyser\OutOfClassScope;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodsClassReflectionExtension;
use _PhpScopere8e811afab72\PHPStan\Type\TypeUtils;
class MixinMethodsClassReflectionExtension implements \_PhpScopere8e811afab72\PHPStan\Reflection\MethodsClassReflectionExtension
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
    public function hasMethod(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : bool
    {
        return $this->findMethod($classReflection, $methodName) !== null;
    }
    public function getMethod(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : \_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection
    {
        $method = $this->findMethod($classReflection, $methodName);
        if ($method === null) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        return $method;
    }
    private function findMethod(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : ?\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection
    {
        $mixinTypes = $classReflection->getResolvedMixinTypes();
        foreach ($mixinTypes as $type) {
            if (\count(\array_intersect(\_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::getDirectClassNames($type), $this->mixinExcludeClasses)) > 0) {
                continue;
            }
            if (!$type->hasMethod($methodName)->yes()) {
                continue;
            }
            $method = $type->getMethod($methodName, new \_PhpScopere8e811afab72\PHPStan\Analyser\OutOfClassScope());
            $static = $method->isStatic();
            if (!$static && $classReflection->hasNativeMethod('__callStatic') && !$classReflection->hasNativeMethod('__call')) {
                $static = \true;
            }
            return new \_PhpScopere8e811afab72\PHPStan\Reflection\Mixin\MixinMethodReflection($method, $static);
        }
        foreach ($classReflection->getParents() as $parentClass) {
            $method = $this->findMethod($parentClass, $methodName);
            if ($method === null) {
                continue;
            }
            return $method;
        }
        return null;
    }
}
