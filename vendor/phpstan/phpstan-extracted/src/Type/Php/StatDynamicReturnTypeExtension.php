<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type\Php;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator;
class StatDynamicReturnTypeExtension implements \_PhpScoper0a2ac50786fa\PHPStan\Type\DynamicFunctionReturnTypeExtension, \_PhpScoper0a2ac50786fa\PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return \in_array($functionReflection->getName(), ['stat', 'lstat', 'fstat', 'ssh2_sftp_stat'], \true);
    }
    public function getTypeFromFunctionCall(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $this->getReturnType();
    }
    public function getClass() : string
    {
        return \SplFileObject::class;
    }
    public function isMethodSupported(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'fstat';
    }
    public function getTypeFromMethodCall(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $this->getReturnType();
    }
    private function getReturnType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $valueType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType();
        $builder = \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
        $keys = ['dev', 'ino', 'mode', 'nlink', 'uid', 'gid', 'rdev', 'size', 'atime', 'mtime', 'ctime', 'blksize', 'blocks'];
        foreach ($keys as $key) {
            $builder->setOffsetValueType(null, $valueType);
        }
        foreach ($keys as $key) {
            $builder->setOffsetValueType(new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType($key), $valueType);
        }
        return \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::union($builder->getArray(), new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType(\false));
    }
}
