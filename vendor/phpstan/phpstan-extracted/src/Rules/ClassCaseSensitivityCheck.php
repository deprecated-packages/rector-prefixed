<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules;

use RectorPrefix20201227\PHPStan\Reflection\ClassReflection;
use RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;
class ClassCaseSensitivityCheck
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var bool */
    private $checkInternalClassCaseSensitivity;
    public function __construct(\RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider $reflectionProvider, bool $checkInternalClassCaseSensitivity = \false)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->checkInternalClassCaseSensitivity = $checkInternalClassCaseSensitivity;
    }
    /**
     * @param ClassNameNodePair[] $pairs
     * @return RuleError[]
     */
    public function checkClassNames(array $pairs) : array
    {
        $errors = [];
        foreach ($pairs as $pair) {
            $className = $pair->getClassName();
            if (!$this->reflectionProvider->hasClass($className)) {
                continue;
            }
            $classReflection = $this->reflectionProvider->getClass($className);
            if (!$this->checkInternalClassCaseSensitivity && $classReflection->isBuiltin()) {
                continue;
                // skip built-in classes
            }
            $realClassName = $classReflection->getName();
            if (\strtolower($realClassName) !== \strtolower($className)) {
                continue;
                // skip class alias
            }
            if ($realClassName === $className) {
                continue;
            }
            $errors[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s %s referenced with incorrect case: %s.', $this->getTypeName($classReflection), $realClassName, $className))->line($pair->getNode()->getLine())->build();
        }
        return $errors;
    }
    private function getTypeName(\RectorPrefix20201227\PHPStan\Reflection\ClassReflection $classReflection) : string
    {
        if ($classReflection->isInterface()) {
            return 'Interface';
        } elseif ($classReflection->isTrait()) {
            return 'Trait';
        }
        return 'Class';
    }
}
