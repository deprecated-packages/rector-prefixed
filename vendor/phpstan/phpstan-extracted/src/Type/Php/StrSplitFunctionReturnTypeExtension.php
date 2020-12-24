<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType;
use _PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\StringType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeUtils;
final class StrSplitFunctionReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    /** @var string[] */
    private $supportedEncodings;
    public function __construct()
    {
        $supportedEncodings = [];
        if (\function_exists('mb_list_encodings')) {
            foreach (\mb_list_encodings() as $encoding) {
                $aliases = \mb_encoding_aliases($encoding);
                if ($aliases === \false) {
                    throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
                }
                $supportedEncodings = \array_merge($supportedEncodings, $aliases, [$encoding]);
            }
        }
        $this->supportedEncodings = \array_map('strtoupper', $supportedEncodings);
    }
    public function isFunctionSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return \in_array($functionReflection->getName(), ['str_split', 'mb_str_split'], \true);
    }
    public function getTypeFromFunctionCall(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $defaultReturnType = \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if (\count($functionCall->args) < 1) {
            return $defaultReturnType;
        }
        if (\count($functionCall->args) >= 2) {
            $splitLengthType = $scope->getType($functionCall->args[1]->value);
            if ($splitLengthType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType) {
                $splitLength = $splitLengthType->getValue();
                if ($splitLength < 1) {
                    return new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType(\false);
                }
            }
        } else {
            $splitLength = 1;
        }
        if ($functionReflection->getName() === 'mb_str_split') {
            if (\count($functionCall->args) >= 3) {
                $strings = \_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::getConstantStrings($scope->getType($functionCall->args[2]->value));
                $values = \array_unique(\array_map(static function (\_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType $encoding) : string {
                    return $encoding->getValue();
                }, $strings));
                if (\count($values) !== 1) {
                    return $defaultReturnType;
                }
                $encoding = $values[0];
                if (!$this->isSupportedEncoding($encoding)) {
                    return new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType(\false);
                }
            } else {
                $encoding = \mb_internal_encoding();
            }
        }
        if (!isset($splitLength)) {
            return $defaultReturnType;
        }
        $stringType = $scope->getType($functionCall->args[0]->value);
        if (!$stringType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(), new \_PhpScopere8e811afab72\PHPStan\Type\StringType());
        }
        $stringValue = $stringType->getValue();
        $items = isset($encoding) ? \mb_str_split($stringValue, $splitLength, $encoding) : \str_split($stringValue, $splitLength);
        if (!\is_array($items)) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        return self::createConstantArrayFrom($items, $scope);
    }
    private function isSupportedEncoding(string $encoding) : bool
    {
        return \in_array(\strtoupper($encoding), $this->supportedEncodings, \true);
    }
    /**
     * @param string[] $constantArray
     * @param \PHPStan\Analyser\Scope $scope
     * @return \PHPStan\Type\Constant\ConstantArrayType
     */
    private static function createConstantArrayFrom(array $constantArray, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType
    {
        $keyTypes = [];
        $valueTypes = [];
        $isList = \true;
        $i = 0;
        foreach ($constantArray as $key => $value) {
            $keyType = $scope->getTypeFromValue($key);
            if (!$keyType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType) {
                throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
            }
            $keyTypes[] = $keyType;
            $valueTypes[] = $scope->getTypeFromValue($value);
            $isList = $isList && $key === $i;
            $i++;
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType($keyTypes, $valueTypes, $isList ? $i : 0);
    }
}
