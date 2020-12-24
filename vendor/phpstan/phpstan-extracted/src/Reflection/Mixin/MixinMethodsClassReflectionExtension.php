<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\Mixin;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\OutOfClassScope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\MethodReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\MethodsClassReflectionExtension;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeUtils;
class MixinMethodsClassReflectionExtension implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\MethodsClassReflectionExtension
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
    public function hasMethod(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : bool
    {
        return $this->findMethod($classReflection, $methodName) !== null;
    }
    public function getMethod(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\MethodReflection
    {
        $method = $this->findMethod($classReflection, $methodName);
        if ($method === null) {
            throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\ShouldNotHappenException();
        }
        return $method;
    }
    private function findMethod(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\MethodReflection
    {
        $mixinTypes = $classReflection->getResolvedMixinTypes();
        foreach ($mixinTypes as $type) {
            if (\count(\array_intersect(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeUtils::getDirectClassNames($type), $this->mixinExcludeClasses)) > 0) {
                continue;
            }
            if (!$type->hasMethod($methodName)->yes()) {
                continue;
            }
            $method = $type->getMethod($methodName, new \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\OutOfClassScope());
            $static = $method->isStatic();
            if (!$static && $classReflection->hasNativeMethod('__callStatic') && !$classReflection->hasNativeMethod('__call')) {
                $static = \true;
            }
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\Mixin\MixinMethodReflection($method, $static);
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
