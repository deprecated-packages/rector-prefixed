<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider;

use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\GlobalConstantReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider;
class MemoizingReflectionProvider implements \_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $provider;
    /** @var array<string, bool> */
    private $hasClasses = [];
    /** @var array<string, \PHPStan\Reflection\ClassReflection> */
    private $classes = [];
    /** @var array<string, string> */
    private $classNames = [];
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider $provider)
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
    public function getClass(string $className) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection
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
    public function getAnonymousClassReflection(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $classNode, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection
    {
        return $this->provider->getAnonymousClassReflection($classNode, $scope);
    }
    public function hasFunction(\_PhpScoperb75b35f52b74\PhpParser\Node\Name $nameNode, ?\_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : bool
    {
        return $this->provider->hasFunction($nameNode, $scope);
    }
    public function getFunction(\_PhpScoperb75b35f52b74\PhpParser\Node\Name $nameNode, ?\_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection
    {
        return $this->provider->getFunction($nameNode, $scope);
    }
    public function resolveFunctionName(\_PhpScoperb75b35f52b74\PhpParser\Node\Name $nameNode, ?\_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : ?string
    {
        return $this->provider->resolveFunctionName($nameNode, $scope);
    }
    public function hasConstant(\_PhpScoperb75b35f52b74\PhpParser\Node\Name $nameNode, ?\_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : bool
    {
        return $this->provider->hasConstant($nameNode, $scope);
    }
    public function getConstant(\_PhpScoperb75b35f52b74\PhpParser\Node\Name $nameNode, ?\_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\GlobalConstantReflection
    {
        return $this->provider->getConstant($nameNode, $scope);
    }
    public function resolveConstantName(\_PhpScoperb75b35f52b74\PhpParser\Node\Name $nameNode, ?\_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : ?string
    {
        return $this->provider->resolveConstantName($nameNode, $scope);
    }
}
