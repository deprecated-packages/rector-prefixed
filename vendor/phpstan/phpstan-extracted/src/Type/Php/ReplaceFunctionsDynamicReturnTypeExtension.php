<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Php;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeUtils;
class ReplaceFunctionsDynamicReturnTypeExtension implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    /** @var array<string, int> */
    private $functions = ['preg_replace' => 2, 'preg_replace_callback' => 2, 'preg_replace_callback_array' => 1, 'str_replace' => 2, 'str_ireplace' => 2, 'substr_replace' => 0];
    public function isFunctionSupported(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return \array_key_exists($functionReflection->getName(), $this->functions);
    }
    public function getTypeFromFunctionCall(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        $type = $this->getPreliminarilyResolvedTypeFromFunctionCall($functionReflection, $functionCall, $scope);
        $possibleTypes = \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if (\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator::containsNull($possibleTypes)) {
            $type = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator::addNull($type);
        }
        return $type;
    }
    private function getPreliminarilyResolvedTypeFromFunctionCall(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        $argumentPosition = $this->functions[$functionReflection->getName()];
        if (\count($functionCall->args) <= $argumentPosition) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $subjectArgumentType = $scope->getType($functionCall->args[$argumentPosition]->value);
        $defaultReturnType = \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if ($subjectArgumentType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeUtils::toBenevolentUnion($defaultReturnType);
        }
        $stringType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType();
        $arrayType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType(), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType());
        $isStringSuperType = $stringType->isSuperTypeOf($subjectArgumentType);
        $isArraySuperType = $arrayType->isSuperTypeOf($subjectArgumentType);
        $compareSuperTypes = $isStringSuperType->compareTo($isArraySuperType);
        if ($compareSuperTypes === $isStringSuperType) {
            return $stringType;
        } elseif ($compareSuperTypes === $isArraySuperType) {
            if ($subjectArgumentType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType) {
                return $subjectArgumentType->generalizeValues();
            }
            return $subjectArgumentType;
        }
        return $defaultReturnType;
    }
}
