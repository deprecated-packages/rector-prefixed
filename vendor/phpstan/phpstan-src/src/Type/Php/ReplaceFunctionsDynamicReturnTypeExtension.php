<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\ArrayType;
use PHPStan\Type\DynamicFunctionReturnTypeExtension;
use PHPStan\Type\MixedType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\TypeUtils;
class ReplaceFunctionsDynamicReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    /** @var array<string, int> */
    private $functions = ['preg_replace' => 2, 'preg_replace_callback' => 2, 'preg_replace_callback_array' => 1, 'str_replace' => 2, 'str_ireplace' => 2, 'substr_replace' => 0];
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return \array_key_exists($functionReflection->getName(), $this->functions);
    }
    public function getTypeFromFunctionCall(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $type = $this->getPreliminarilyResolvedTypeFromFunctionCall($functionReflection, $functionCall, $scope);
        $possibleTypes = \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if (\PHPStan\Type\TypeCombinator::containsNull($possibleTypes)) {
            $type = \PHPStan\Type\TypeCombinator::addNull($type);
        }
        return $type;
    }
    private function getPreliminarilyResolvedTypeFromFunctionCall(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $argumentPosition = $this->functions[$functionReflection->getName()];
        if (\count($functionCall->args) <= $argumentPosition) {
            return \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $subjectArgumentType = $scope->getType($functionCall->args[$argumentPosition]->value);
        $defaultReturnType = \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if ($subjectArgumentType instanceof \PHPStan\Type\MixedType) {
            return \PHPStan\Type\TypeUtils::toBenevolentUnion($defaultReturnType);
        }
        $stringType = new \PHPStan\Type\StringType();
        $arrayType = new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType());
        $isStringSuperType = $stringType->isSuperTypeOf($subjectArgumentType);
        $isArraySuperType = $arrayType->isSuperTypeOf($subjectArgumentType);
        $compareSuperTypes = $isStringSuperType->compareTo($isArraySuperType);
        if ($compareSuperTypes === $isStringSuperType) {
            return $stringType;
        } elseif ($compareSuperTypes === $isArraySuperType) {
            if ($subjectArgumentType instanceof \PHPStan\Type\ArrayType) {
                return $subjectArgumentType->generalizeValues();
            }
            return $subjectArgumentType;
        }
        return $defaultReturnType;
    }
}
