<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Php;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\MethodReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator;
class StatDynamicReturnTypeExtension implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\DynamicFunctionReturnTypeExtension, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return \in_array($functionReflection->getName(), ['stat', 'lstat', 'fstat', 'ssh2_sftp_stat'], \true);
    }
    public function getTypeFromFunctionCall(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return $this->getReturnType();
    }
    public function getClass() : string
    {
        return \SplFileObject::class;
    }
    public function isMethodSupported(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'fstat';
    }
    public function getTypeFromMethodCall(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return $this->getReturnType();
    }
    private function getReturnType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        $valueType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType();
        $builder = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
        $keys = ['dev', 'ino', 'mode', 'nlink', 'uid', 'gid', 'rdev', 'size', 'atime', 'mtime', 'ctime', 'blksize', 'blocks'];
        foreach ($keys as $key) {
            $builder->setOffsetValueType(null, $valueType);
        }
        foreach ($keys as $key) {
            $builder->setOffsetValueType(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType($key), $valueType);
        }
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator::union($builder->getArray(), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType(\false));
    }
}
