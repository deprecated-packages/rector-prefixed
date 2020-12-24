<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Php\PhpVersion;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Type\Accessory\NonEmptyArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerRangeType;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\NeverType;
use _PhpScopere8e811afab72\PHPStan\Type\StringType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeCombinator;
use _PhpScopere8e811afab72\PHPStan\Type\TypeUtils;
class ExplodeFunctionDynamicReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    /** @var PhpVersion */
    private $phpVersion;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Php\PhpVersion $phpVersion)
    {
        $this->phpVersion = $phpVersion;
    }
    public function isFunctionSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'explode';
    }
    public function getTypeFromFunctionCall(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 2) {
            return \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $delimiterType = $scope->getType($functionCall->args[0]->value);
        $isSuperset = (new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType(''))->isSuperTypeOf($delimiterType);
        if ($isSuperset->yes()) {
            if ($this->phpVersion->getVersionId() >= 80000) {
                return new \_PhpScopere8e811afab72\PHPStan\Type\NeverType();
            }
            return new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType(\false);
        } elseif ($isSuperset->no()) {
            $arrayType = new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(), new \_PhpScopere8e811afab72\PHPStan\Type\StringType());
            if (!isset($functionCall->args[2]) || \_PhpScopere8e811afab72\PHPStan\Type\IntegerRangeType::fromInterval(0, null)->isSuperTypeOf($scope->getType($functionCall->args[2]->value))->yes()) {
                return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::intersect($arrayType, new \_PhpScopere8e811afab72\PHPStan\Type\Accessory\NonEmptyArrayType());
            }
            return $arrayType;
        }
        $returnType = \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if ($delimiterType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return \_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::toBenevolentUnion($returnType);
        }
        return $returnType;
    }
}
