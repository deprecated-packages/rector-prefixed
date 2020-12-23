<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider;

use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\GlobalConstantReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider;
class ChainReflectionProvider implements \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider
{
    /** @var \PHPStan\Reflection\ReflectionProvider[] */
    private $providers;
    /**
     * @param \PHPStan\Reflection\ReflectionProvider[] $providers
     */
    public function __construct(array $providers)
    {
        $this->providers = $providers;
    }
    public function hasClass(string $className) : bool
    {
        foreach ($this->providers as $provider) {
            if (!$provider->hasClass($className)) {
                continue;
            }
            return \true;
        }
        return \false;
    }
    public function getClass(string $className) : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection
    {
        foreach ($this->providers as $provider) {
            if (!$provider->hasClass($className)) {
                continue;
            }
            return $provider->getClass($className);
        }
        throw new \_PhpScoper0a2ac50786fa\PHPStan\Broker\ClassNotFoundException($className);
    }
    public function getClassName(string $className) : string
    {
        foreach ($this->providers as $provider) {
            if (!$provider->hasClass($className)) {
                continue;
            }
            return $provider->getClassName($className);
        }
        throw new \_PhpScoper0a2ac50786fa\PHPStan\Broker\ClassNotFoundException($className);
    }
    public function supportsAnonymousClasses() : bool
    {
        foreach ($this->providers as $provider) {
            if (!$provider->supportsAnonymousClasses()) {
                continue;
            }
            return \true;
        }
        return \false;
    }
    public function getAnonymousClassReflection(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $classNode, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection
    {
        foreach ($this->providers as $provider) {
            if (!$provider->supportsAnonymousClasses()) {
                continue;
            }
            return $provider->getAnonymousClassReflection($classNode, $scope);
        }
        throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
    }
    public function hasFunction(\_PhpScoper0a2ac50786fa\PhpParser\Node\Name $nameNode, ?\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : bool
    {
        foreach ($this->providers as $provider) {
            if (!$provider->hasFunction($nameNode, $scope)) {
                continue;
            }
            return \true;
        }
        return \false;
    }
    public function getFunction(\_PhpScoper0a2ac50786fa\PhpParser\Node\Name $nameNode, ?\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection
    {
        foreach ($this->providers as $provider) {
            if (!$provider->hasFunction($nameNode, $scope)) {
                continue;
            }
            return $provider->getFunction($nameNode, $scope);
        }
        throw new \_PhpScoper0a2ac50786fa\PHPStan\Broker\FunctionNotFoundException((string) $nameNode);
    }
    public function resolveFunctionName(\_PhpScoper0a2ac50786fa\PhpParser\Node\Name $nameNode, ?\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : ?string
    {
        foreach ($this->providers as $provider) {
            $resolvedName = $provider->resolveFunctionName($nameNode, $scope);
            if ($resolvedName === null) {
                continue;
            }
            return $resolvedName;
        }
        return null;
    }
    public function hasConstant(\_PhpScoper0a2ac50786fa\PhpParser\Node\Name $nameNode, ?\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : bool
    {
        foreach ($this->providers as $provider) {
            if (!$provider->hasConstant($nameNode, $scope)) {
                continue;
            }
            return \true;
        }
        return \false;
    }
    public function getConstant(\_PhpScoper0a2ac50786fa\PhpParser\Node\Name $nameNode, ?\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\GlobalConstantReflection
    {
        foreach ($this->providers as $provider) {
            if (!$provider->hasConstant($nameNode, $scope)) {
                continue;
            }
            return $provider->getConstant($nameNode, $scope);
        }
        throw new \_PhpScoper0a2ac50786fa\PHPStan\Broker\ConstantNotFoundException((string) $nameNode);
    }
    public function resolveConstantName(\_PhpScoper0a2ac50786fa\PhpParser\Node\Name $nameNode, ?\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : ?string
    {
        foreach ($this->providers as $provider) {
            $resolvedName = $provider->resolveConstantName($nameNode, $scope);
            if ($resolvedName === null) {
                continue;
            }
            return $resolvedName;
        }
        return null;
    }
}
