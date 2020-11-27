<?php

declare (strict_types=1);
namespace PHPStan\Reflection\BetterReflection\Reflector;

use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\Reflection;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflector\ConstantReflector;
final class MemoizingConstantReflector extends \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflector\ConstantReflector
{
    /** @var array<string, \Roave\BetterReflection\Reflection\ReflectionConstant|\Throwable> */
    private $reflections = [];
    /**
     * Create a ReflectionConstant for the specified $constantName.
     *
     * @return \Roave\BetterReflection\Reflection\ReflectionConstant
     *
     * @throws \Roave\BetterReflection\Reflector\Exception\IdentifierNotFound
     */
    public function reflect(string $constantName) : \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\Reflection
    {
        if (isset($this->reflections[$constantName])) {
            if ($this->reflections[$constantName] instanceof \Throwable) {
                throw $this->reflections[$constantName];
            }
            return $this->reflections[$constantName];
        }
        try {
            return $this->reflections[$constantName] = parent::reflect($constantName);
        } catch (\Throwable $e) {
            $this->reflections[$constantName] = $e;
            throw $e;
        }
    }
}
