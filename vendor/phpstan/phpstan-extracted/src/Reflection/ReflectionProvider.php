<?php

declare (strict_types=1);
namespace PHPStan\Reflection;

use PHPStan\Analyser\Scope;
interface ReflectionProvider
{
    public function hasClass(string $className) : bool;
    public function getClass(string $className) : \PHPStan\Reflection\ClassReflection;
    public function getClassName(string $className) : string;
    public function supportsAnonymousClasses() : bool;
    public function getAnonymousClassReflection(\PhpParser\Node\Stmt\Class_ $classNode, \PHPStan\Analyser\Scope $scope) : \PHPStan\Reflection\ClassReflection;
    public function hasFunction(\PhpParser\Node\Name $nameNode, ?\PHPStan\Analyser\Scope $scope) : bool;
    public function getFunction(\PhpParser\Node\Name $nameNode, ?\PHPStan\Analyser\Scope $scope) : \PHPStan\Reflection\FunctionReflection;
    public function resolveFunctionName(\PhpParser\Node\Name $nameNode, ?\PHPStan\Analyser\Scope $scope) : ?string;
    public function hasConstant(\PhpParser\Node\Name $nameNode, ?\PHPStan\Analyser\Scope $scope) : bool;
    public function getConstant(\PhpParser\Node\Name $nameNode, ?\PHPStan\Analyser\Scope $scope) : \PHPStan\Reflection\GlobalConstantReflection;
    public function resolveConstantName(\PhpParser\Node\Name $nameNode, ?\PHPStan\Analyser\Scope $scope) : ?string;
}
