<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Php;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Php\PhpVersion;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a6b37af0871\PHPStan\Type\Accessory\NonEmptyArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntegerType;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\NeverType;
use _PhpScoper0a6b37af0871\PHPStan\Type\StringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils;
class ExplodeFunctionDynamicReturnTypeExtension implements \_PhpScoper0a6b37af0871\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    /** @var PhpVersion */
    private $phpVersion;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Php\PhpVersion $phpVersion)
    {
        $this->phpVersion = $phpVersion;
    }
    public function isFunctionSupported(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'explode';
    }
    public function getTypeFromFunctionCall(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 2) {
            return \_PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $delimiterType = $scope->getType($functionCall->args[0]->value);
        $isSuperset = (new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType(''))->isSuperTypeOf($delimiterType);
        if ($isSuperset->yes()) {
            if ($this->phpVersion->getVersionId() >= 80000) {
                return new \_PhpScoper0a6b37af0871\PHPStan\Type\NeverType();
            }
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType(\false);
        } elseif ($isSuperset->no()) {
            $arrayType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\StringType());
            if (!isset($functionCall->args[2]) || \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType::fromInterval(0, null)->isSuperTypeOf($scope->getType($functionCall->args[2]->value))->yes()) {
                return \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::intersect($arrayType, new \_PhpScoper0a6b37af0871\PHPStan\Type\Accessory\NonEmptyArrayType());
            }
            return $arrayType;
        }
        $returnType = \_PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if ($delimiterType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType) {
            return \_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::toBenevolentUnion($returnType);
        }
        return $returnType;
    }
}
