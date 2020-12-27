<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;

use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Reflection\ClassReflection;
use RectorPrefix20201227\PHPStan\Reflection\FunctionReflection;
use RectorPrefix20201227\PHPStan\Reflection\GlobalConstantReflection;
use RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;
class MemoizingReflectionProvider implements \RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $provider;
    /** @var array<string, bool> */
    private $hasClasses = [];
    /** @var array<string, \PHPStan\Reflection\ClassReflection> */
    private $classes = [];
    /** @var array<string, string> */
    private $classNames = [];
    public function __construct(\RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider $provider)
    {
        $this->provider = $provider;
    }
    public function hasClass(string $className) : bool
    {
        $lowerClassName = \strtolower($className);
        if (isset($this->hasClasses[$lowerClassName])) {
            return $this->hasClasses[$lowerClassName];
        }
        return $this->hasClasses[$lowerClassName] = $this->provider->hasClass($className);
    }
    public function getClass(string $className) : \RectorPrefix20201227\PHPStan\Reflection\ClassReflection
    {
        $lowerClassName = \strtolower($className);
        if (isset($this->classes[$lowerClassName])) {
            return $this->classes[$lowerClassName];
        }
        return $this->classes[$lowerClassName] = $this->provider->getClass($className);
    }
    public function getClassName(string $className) : string
    {
        $lowerClassName = \strtolower($className);
        if (isset($this->classNames[$lowerClassName])) {
            return $this->classNames[$lowerClassName];
        }
        return $this->classNames[$lowerClassName] = $this->provider->getClassName($className);
    }
    public function supportsAnonymousClasses() : bool
    {
        return $this->provider->supportsAnonymousClasses();
    }
    public function getAnonymousClassReflection(\PhpParser\Node\Stmt\Class_ $classNode, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : \RectorPrefix20201227\PHPStan\Reflection\ClassReflection
    {
        return $this->provider->getAnonymousClassReflection($classNode, $scope);
    }
    public function hasFunction(\PhpParser\Node\Name $nameNode, ?\RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : bool
    {
        return $this->provider->hasFunction($nameNode, $scope);
    }
    public function getFunction(\PhpParser\Node\Name $nameNode, ?\RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : \RectorPrefix20201227\PHPStan\Reflection\FunctionReflection
    {
        return $this->provider->getFunction($nameNode, $scope);
    }
    public function resolveFunctionName(\PhpParser\Node\Name $nameNode, ?\RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : ?string
    {
        return $this->provider->resolveFunctionName($nameNode, $scope);
    }
    public function hasConstant(\PhpParser\Node\Name $nameNode, ?\RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : bool
    {
        return $this->provider->hasConstant($nameNode, $scope);
    }
    public function getConstant(\PhpParser\Node\Name $nameNode, ?\RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : \RectorPrefix20201227\PHPStan\Reflection\GlobalConstantReflection
    {
        return $this->provider->getConstant($nameNode, $scope);
    }
    public function resolveConstantName(\PhpParser\Node\Name $nameNode, ?\RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : ?string
    {
        return $this->provider->resolveConstantName($nameNode, $scope);
    }
}
