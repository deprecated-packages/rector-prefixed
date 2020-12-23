<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Reflection\Mixin;

use _PhpScoper0a2ac50786fa\PHPStan\Analyser\OutOfClassScope;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodsClassReflectionExtension;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeUtils;
class MixinMethodsClassReflectionExtension implements \_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodsClassReflectionExtension
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
    public function hasMethod(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : bool
    {
        return $this->findMethod($classReflection, $methodName) !== null;
    }
    public function getMethod(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection
    {
        $method = $this->findMethod($classReflection, $methodName);
        if ($method === null) {
            throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
        }
        return $method;
    }
    private function findMethod(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : ?\_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection
    {
        $mixinTypes = $classReflection->getResolvedMixinTypes();
        foreach ($mixinTypes as $type) {
            if (\count(\array_intersect(\_PhpScoper0a2ac50786fa\PHPStan\Type\TypeUtils::getDirectClassNames($type), $this->mixinExcludeClasses)) > 0) {
                continue;
            }
            if (!$type->hasMethod($methodName)->yes()) {
                continue;
            }
            $method = $type->getMethod($methodName, new \_PhpScoper0a2ac50786fa\PHPStan\Analyser\OutOfClassScope());
            $static = $method->isStatic();
            if (!$static && $classReflection->hasNativeMethod('__callStatic') && !$classReflection->hasNativeMethod('__call')) {
                $static = \true;
            }
            return new \_PhpScoper0a2ac50786fa\PHPStan\Reflection\Mixin\MixinMethodReflection($method, $static);
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
