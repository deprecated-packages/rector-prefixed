<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection;

use RectorPrefix20201227\PHPStan\Analyser\Scope;
interface ReflectionProvider
{
    public function hasClass(string $className) : bool;
    public function getClass(string $className) : \RectorPrefix20201227\PHPStan\Reflection\ClassReflection;
    public function getClassName(string $className) : string;
    public function supportsAnonymousClasses() : bool;
    public function getAnonymousClassReflection(\PhpParser\Node\Stmt\Class_ $classNode, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : \RectorPrefix20201227\PHPStan\Reflection\ClassReflection;
    public function hasFunction(\PhpParser\Node\Name $nameNode, ?\RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : bool;
    public function getFunction(\PhpParser\Node\Name $nameNode, ?\RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : \RectorPrefix20201227\PHPStan\Reflection\FunctionReflection;
    public function resolveFunctionName(\PhpParser\Node\Name $nameNode, ?\RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : ?string;
    public function hasConstant(\PhpParser\Node\Name $nameNode, ?\RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : bool;
    public function getConstant(\PhpParser\Node\Name $nameNode, ?\RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : \RectorPrefix20201227\PHPStan\Reflection\GlobalConstantReflection;
    public function resolveConstantName(\PhpParser\Node\Name $nameNode, ?\RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : ?string;
}
