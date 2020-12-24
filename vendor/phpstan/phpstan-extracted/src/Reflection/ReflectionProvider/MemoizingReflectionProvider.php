<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;

use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\GlobalConstantReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
class MemoizingReflectionProvider implements \_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $provider;
    /** @var array<string, bool> */
    private $hasClasses = [];
    /** @var array<string, \PHPStan\Reflection\ClassReflection> */
    private $classes = [];
    /** @var array<string, string> */
    private $classNames = [];
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider $provider)
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
    public function getClass(string $className) : \_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection
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
    public function getAnonymousClassReflection(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $classNode, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection
    {
        return $this->provider->getAnonymousClassReflection($classNode, $scope);
    }
    public function hasFunction(\_PhpScopere8e811afab72\PhpParser\Node\Name $nameNode, ?\_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : bool
    {
        return $this->provider->hasFunction($nameNode, $scope);
    }
    public function getFunction(\_PhpScopere8e811afab72\PhpParser\Node\Name $nameNode, ?\_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection
    {
        return $this->provider->getFunction($nameNode, $scope);
    }
    public function resolveFunctionName(\_PhpScopere8e811afab72\PhpParser\Node\Name $nameNode, ?\_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : ?string
    {
        return $this->provider->resolveFunctionName($nameNode, $scope);
    }
    public function hasConstant(\_PhpScopere8e811afab72\PhpParser\Node\Name $nameNode, ?\_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : bool
    {
        return $this->provider->hasConstant($nameNode, $scope);
    }
    public function getConstant(\_PhpScopere8e811afab72\PhpParser\Node\Name $nameNode, ?\_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Reflection\GlobalConstantReflection
    {
        return $this->provider->getConstant($nameNode, $scope);
    }
    public function resolveConstantName(\_PhpScopere8e811afab72\PhpParser\Node\Name $nameNode, ?\_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : ?string
    {
        return $this->provider->resolveConstantName($nameNode, $scope);
    }
}
