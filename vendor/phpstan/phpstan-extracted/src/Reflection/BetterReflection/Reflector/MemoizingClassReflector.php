<?php

declare (strict_types=1);
namespace PHPStan\Reflection\BetterReflection\Reflector;

use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ClassReflector;
final class MemoizingClassReflector extends \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ClassReflector
{
    /** @var array<string, \Roave\BetterReflection\Reflection\ReflectionClass|\Throwable> */
    private $reflections = [];
    /**
     * Create a ReflectionClass for the specified $className.
     *
     * @return \Roave\BetterReflection\Reflection\ReflectionClass
     *
     * @throws \Roave\BetterReflection\Reflector\Exception\IdentifierNotFound
     */
    public function reflect(string $className) : \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection
    {
        $lowerClassName = \strtolower($className);
        if (isset($this->reflections[$lowerClassName])) {
            if ($this->reflections[$lowerClassName] instanceof \Throwable) {
                throw $this->reflections[$lowerClassName];
            }
            return $this->reflections[$lowerClassName];
        }
        try {
            return $this->reflections[$lowerClassName] = parent::reflect($className);
        } catch (\Throwable $e) {
            $this->reflections[$lowerClassName] = $e;
            throw $e;
        }
    }
}
