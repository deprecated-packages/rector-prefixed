<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
class StatDynamicReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension, \PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return \in_array($functionReflection->getName(), ['stat', 'lstat', 'fstat', 'ssh2_sftp_stat'], \true);
    }
    public function getTypeFromFunctionCall(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        return $this->getReturnType();
    }
    public function getClass() : string
    {
        return \SplFileObject::class;
    }
    public function isMethodSupported(\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'fstat';
    }
    public function getTypeFromMethodCall(\PHPStan\Reflection\MethodReflection $methodReflection, \PhpParser\Node\Expr\MethodCall $methodCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        return $this->getReturnType();
    }
    private function getReturnType() : \PHPStan\Type\Type
    {
        $valueType = new \PHPStan\Type\IntegerType();
        $builder = \PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
        $keys = ['dev', 'ino', 'mode', 'nlink', 'uid', 'gid', 'rdev', 'size', 'atime', 'mtime', 'ctime', 'blksize', 'blocks'];
        foreach ($keys as $key) {
            $builder->setOffsetValueType(null, $valueType);
        }
        foreach ($keys as $key) {
            $builder->setOffsetValueType(new \PHPStan\Type\Constant\ConstantStringType($key), $valueType);
        }
        return \PHPStan\Type\TypeCombinator::union($builder->getArray(), new \PHPStan\Type\Constant\ConstantBooleanType(\false));
    }
}
