<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type\Php;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\StringType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeUtils;
class ReplaceFunctionsDynamicReturnTypeExtension implements \_PhpScoper0a2ac50786fa\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    /** @var array<string, int> */
    private $functions = ['preg_replace' => 2, 'preg_replace_callback' => 2, 'preg_replace_callback_array' => 1, 'str_replace' => 2, 'str_ireplace' => 2, 'substr_replace' => 0];
    public function isFunctionSupported(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return \array_key_exists($functionReflection->getName(), $this->functions);
    }
    public function getTypeFromFunctionCall(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $type = $this->getPreliminarilyResolvedTypeFromFunctionCall($functionReflection, $functionCall, $scope);
        $possibleTypes = \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if (\_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::containsNull($possibleTypes)) {
            $type = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::addNull($type);
        }
        return $type;
    }
    private function getPreliminarilyResolvedTypeFromFunctionCall(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $argumentPosition = $this->functions[$functionReflection->getName()];
        if (\count($functionCall->args) <= $argumentPosition) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $subjectArgumentType = $scope->getType($functionCall->args[$argumentPosition]->value);
        $defaultReturnType = \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if ($subjectArgumentType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeUtils::toBenevolentUnion($defaultReturnType);
        }
        $stringType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\StringType();
        $arrayType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType(new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType(), new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType());
        $isStringSuperType = $stringType->isSuperTypeOf($subjectArgumentType);
        $isArraySuperType = $arrayType->isSuperTypeOf($subjectArgumentType);
        $compareSuperTypes = $isStringSuperType->compareTo($isArraySuperType);
        if ($compareSuperTypes === $isStringSuperType) {
            return $stringType;
        } elseif ($compareSuperTypes === $isArraySuperType) {
            if ($subjectArgumentType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType) {
                return $subjectArgumentType->generalizeValues();
            }
            return $subjectArgumentType;
        }
        return $defaultReturnType;
    }
}
