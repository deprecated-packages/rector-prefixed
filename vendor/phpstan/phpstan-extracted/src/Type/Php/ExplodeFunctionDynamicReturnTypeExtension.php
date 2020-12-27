<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Php\PhpVersion;
use RectorPrefix20201227\PHPStan\Reflection\FunctionReflection;
use RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\Accessory\NonEmptyArrayType;
use PHPStan\Type\ArrayType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\IntegerRangeType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\MixedType;
use PHPStan\Type\NeverType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\TypeUtils;
class ExplodeFunctionDynamicReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    /** @var PhpVersion */
    private $phpVersion;
    public function __construct(\RectorPrefix20201227\PHPStan\Php\PhpVersion $phpVersion)
    {
        $this->phpVersion = $phpVersion;
    }
    public function isFunctionSupported(\RectorPrefix20201227\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'explode';
    }
    public function getTypeFromFunctionCall(\RectorPrefix20201227\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 2) {
            return \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $delimiterType = $scope->getType($functionCall->args[0]->value);
        $isSuperset = (new \PHPStan\Type\Constant\ConstantStringType(''))->isSuperTypeOf($delimiterType);
        if ($isSuperset->yes()) {
            if ($this->phpVersion->getVersionId() >= 80000) {
                return new \PHPStan\Type\NeverType();
            }
            return new \PHPStan\Type\Constant\ConstantBooleanType(\false);
        } elseif ($isSuperset->no()) {
            $arrayType = new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType());
            if (!isset($functionCall->args[2]) || \PHPStan\Type\IntegerRangeType::fromInterval(0, null)->isSuperTypeOf($scope->getType($functionCall->args[2]->value))->yes()) {
                return \PHPStan\Type\TypeCombinator::intersect($arrayType, new \PHPStan\Type\Accessory\NonEmptyArrayType());
            }
            return $arrayType;
        }
        $returnType = \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if ($delimiterType instanceof \PHPStan\Type\MixedType) {
            return \PHPStan\Type\TypeUtils::toBenevolentUnion($returnType);
        }
        return $returnType;
    }
}
