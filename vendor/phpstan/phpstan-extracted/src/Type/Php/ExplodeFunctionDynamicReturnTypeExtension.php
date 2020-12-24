<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Php;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Php\PhpVersion;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoperb75b35f52b74\PHPStan\Type\Accessory\NonEmptyArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntegerRangeType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntegerType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\NeverType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils;
class ExplodeFunctionDynamicReturnTypeExtension implements \_PhpScoperb75b35f52b74\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    /** @var PhpVersion */
    private $phpVersion;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Php\PhpVersion $phpVersion)
    {
        $this->phpVersion = $phpVersion;
    }
    public function isFunctionSupported(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'explode';
    }
    public function getTypeFromFunctionCall(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 2) {
            return \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $delimiterType = $scope->getType($functionCall->args[0]->value);
        $isSuperset = (new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType(''))->isSuperTypeOf($delimiterType);
        if ($isSuperset->yes()) {
            if ($this->phpVersion->getVersionId() >= 80000) {
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\NeverType();
            }
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType(\false);
        } elseif ($isSuperset->no()) {
            $arrayType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType(new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType());
            if (!isset($functionCall->args[2]) || \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerRangeType::fromInterval(0, null)->isSuperTypeOf($scope->getType($functionCall->args[2]->value))->yes()) {
                return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::intersect($arrayType, new \_PhpScoperb75b35f52b74\PHPStan\Type\Accessory\NonEmptyArrayType());
            }
            return $arrayType;
        }
        $returnType = \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if ($delimiterType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
            return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::toBenevolentUnion($returnType);
        }
        return $returnType;
    }
}
