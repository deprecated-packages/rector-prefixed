<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection\BetterReflection\Reflector;

use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector;
final class MemoizingFunctionReflector extends \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector
{
    /** @var array<string, \Roave\BetterReflection\Reflection\ReflectionFunction|\Throwable> */
    private $reflections = [];
    /**
     * Create a ReflectionFunction for the specified $functionName.
     *
     * @return \Roave\BetterReflection\Reflection\ReflectionFunction
     *
     * @throws \Roave\BetterReflection\Reflector\Exception\IdentifierNotFound
     */
    public function reflect(string $functionName) : \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection
    {
        $lowerFunctionName = \strtolower($functionName);
        if (isset($this->reflections[$lowerFunctionName])) {
            if ($this->reflections[$lowerFunctionName] instanceof \Throwable) {
                throw $this->reflections[$lowerFunctionName];
            }
            return $this->reflections[$lowerFunctionName];
        }
        try {
            return $this->reflections[$lowerFunctionName] = parent::reflect($functionName);
        } catch (\Throwable $e) {
            $this->reflections[$lowerFunctionName] = $e;
            throw $e;
        }
    }
}
