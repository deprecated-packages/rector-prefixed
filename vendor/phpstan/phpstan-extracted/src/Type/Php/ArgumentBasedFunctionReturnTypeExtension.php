<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Reflection\FunctionReflection;
use RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\ArrayType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeUtils;
class ArgumentBasedFunctionReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    /** @var int[] */
    private $functionNames = ['array_unique' => 0, 'array_reverse' => 0, 'array_change_key_case' => 0, 'array_diff_assoc' => 0, 'array_diff_key' => 0, 'array_diff_uassoc' => 0, 'array_diff_ukey' => 0, 'array_diff' => 0, 'array_udiff_assoc' => 0, 'array_udiff_uassoc' => 0, 'array_udiff' => 0, 'array_intersect_assoc' => 0, 'array_intersect_key' => 0, 'array_intersect_uassoc' => 0, 'array_intersect_ukey' => 0, 'array_intersect' => 0, 'array_uintersect_assoc' => 0, 'array_uintersect_uassoc' => 0, 'array_uintersect' => 0, 'iterator_to_array' => 0];
    public function isFunctionSupported(\RectorPrefix20201227\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return isset($this->functionNames[$functionReflection->getName()]);
    }
    public function getTypeFromFunctionCall(\RectorPrefix20201227\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $argumentPosition = $this->functionNames[$functionReflection->getName()];
        if (!isset($functionCall->args[$argumentPosition])) {
            return \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $argument = $functionCall->args[$argumentPosition];
        $argumentType = $scope->getType($argument->value);
        $argumentKeyType = $argumentType->getIterableKeyType();
        $argumentValueType = $argumentType->getIterableValueType();
        if ($argument->unpack) {
            $argumentKeyType = \PHPStan\Type\TypeUtils::generalizeType($argumentKeyType);
            $argumentValueType = \PHPStan\Type\TypeUtils::generalizeType($argumentValueType->getIterableValueType());
        }
        return new \PHPStan\Type\ArrayType($argumentKeyType, $argumentValueType);
    }
}
