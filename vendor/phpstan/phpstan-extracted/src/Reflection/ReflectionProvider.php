<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection;

use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
interface ReflectionProvider
{
    public function hasClass(string $className) : bool;
    public function getClass(string $className) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection;
    public function getClassName(string $className) : string;
    public function supportsAnonymousClasses() : bool;
    public function getAnonymousClassReflection(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $classNode, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection;
    public function hasFunction(\_PhpScoperb75b35f52b74\PhpParser\Node\Name $nameNode, ?\_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : bool;
    public function getFunction(\_PhpScoperb75b35f52b74\PhpParser\Node\Name $nameNode, ?\_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection;
    public function resolveFunctionName(\_PhpScoperb75b35f52b74\PhpParser\Node\Name $nameNode, ?\_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : ?string;
    public function hasConstant(\_PhpScoperb75b35f52b74\PhpParser\Node\Name $nameNode, ?\_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : bool;
    public function getConstant(\_PhpScoperb75b35f52b74\PhpParser\Node\Name $nameNode, ?\_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\GlobalConstantReflection;
    public function resolveConstantName(\_PhpScoperb75b35f52b74\PhpParser\Node\Name $nameNode, ?\_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : ?string;
}
