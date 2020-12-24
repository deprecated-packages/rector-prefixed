<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection\BetterReflection\Reflector;

use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ConstantReflector;
final class MemoizingConstantReflector extends \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ConstantReflector
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
    public function reflect(string $constantName) : \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection
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