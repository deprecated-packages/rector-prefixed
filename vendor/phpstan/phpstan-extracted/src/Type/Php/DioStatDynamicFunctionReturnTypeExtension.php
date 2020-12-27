<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Reflection\FunctionReflection;
use PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
class DioStatDynamicFunctionReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\RectorPrefix20201227\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'dio_stat';
    }
    public function getTypeFromFunctionCall(\RectorPrefix20201227\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $valueType = new \PHPStan\Type\IntegerType();
        $builder = \PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
        $keys = ['device', 'inode', 'mode', 'nlink', 'uid', 'gid', 'device_type', 'size', 'blocksize', 'blocks', 'atime', 'mtime', 'ctime'];
        foreach ($keys as $key) {
            $builder->setOffsetValueType(new \PHPStan\Type\Constant\ConstantStringType($key), $valueType);
        }
        return \PHPStan\Type\TypeCombinator::addNull($builder->getArray());
    }
}
