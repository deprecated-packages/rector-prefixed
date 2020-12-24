<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection\Mixin;

use _PhpScoperb75b35f52b74\PHPStan\Analyser\OutOfClassScope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\MethodsClassReflectionExtension;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils;
class MixinMethodsClassReflectionExtension implements \_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodsClassReflectionExtension
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
    public function hasMethod(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : bool
    {
        return $this->findMethod($classReflection, $methodName) !== null;
    }
    public function getMethod(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection
    {
        $method = $this->findMethod($classReflection, $methodName);
        if ($method === null) {
            throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
        }
        return $method;
    }
    private function findMethod(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : ?\_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection
    {
        $mixinTypes = $classReflection->getResolvedMixinTypes();
        foreach ($mixinTypes as $type) {
            if (\count(\array_intersect(\_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::getDirectClassNames($type), $this->mixinExcludeClasses)) > 0) {
                continue;
            }
            if (!$type->hasMethod($methodName)->yes()) {
                continue;
            }
            $method = $type->getMethod($methodName, new \_PhpScoperb75b35f52b74\PHPStan\Analyser\OutOfClassScope());
            $static = $method->isStatic();
            if (!$static && $classReflection->hasNativeMethod('__callStatic') && !$classReflection->hasNativeMethod('__call')) {
                $static = \true;
            }
            return new \_PhpScoperb75b35f52b74\PHPStan\Reflection\Mixin\MixinMethodReflection($method, $static);
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
