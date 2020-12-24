<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
interface ReflectionProvider
{
    public function hasClass(string $className) : bool;
    public function getClass(string $className) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassReflection;
    public function getClassName(string $className) : string;
    public function supportsAnonymousClasses() : bool;
    public function getAnonymousClassReflection(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $classNode, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassReflection;
    public function hasFunction(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name $nameNode, ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : bool;
    public function getFunction(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name $nameNode, ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection;
    public function resolveFunctionName(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name $nameNode, ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : ?string;
    public function hasConstant(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name $nameNode, ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : bool;
    public function getConstant(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name $nameNode, ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\GlobalConstantReflection;
    public function resolveConstantName(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name $nameNode, ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : ?string;
}
