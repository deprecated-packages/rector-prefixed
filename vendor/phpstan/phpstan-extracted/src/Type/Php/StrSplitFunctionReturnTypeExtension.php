<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Php;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeUtils;
final class StrSplitFunctionReturnTypeExtension implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\DynamicFunctionReturnTypeExtension
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
                    throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\ShouldNotHappenException();
                }
                $supportedEncodings = \array_merge($supportedEncodings, $aliases, [$encoding]);
            }
        }
        $this->supportedEncodings = \array_map('strtoupper', $supportedEncodings);
    }
    public function isFunctionSupported(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return \in_array($functionReflection->getName(), ['str_split', 'mb_str_split'], \true);
    }
    public function getTypeFromFunctionCall(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        $defaultReturnType = \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if (\count($functionCall->args) < 1) {
            return $defaultReturnType;
        }
        if (\count($functionCall->args) >= 2) {
            $splitLengthType = $scope->getType($functionCall->args[1]->value);
            if ($splitLengthType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantIntegerType) {
                $splitLength = $splitLengthType->getValue();
                if ($splitLength < 1) {
                    return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType(\false);
                }
            }
        } else {
            $splitLength = 1;
        }
        if ($functionReflection->getName() === 'mb_str_split') {
            if (\count($functionCall->args) >= 3) {
                $strings = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeUtils::getConstantStrings($scope->getType($functionCall->args[2]->value));
                $values = \array_unique(\array_map(static function (\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType $encoding) : string {
                    return $encoding->getValue();
                }, $strings));
                if (\count($values) !== 1) {
                    return $defaultReturnType;
                }
                $encoding = $values[0];
                if (!$this->isSupportedEncoding($encoding)) {
                    return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType(\false);
                }
            } else {
                $encoding = \mb_internal_encoding();
            }
        }
        if (!isset($splitLength)) {
            return $defaultReturnType;
        }
        $stringType = $scope->getType($functionCall->args[0]->value);
        if (!$stringType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType) {
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType(), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType());
        }
        $stringValue = $stringType->getValue();
        $items = isset($encoding) ? \mb_str_split($stringValue, $splitLength, $encoding) : \str_split($stringValue, $splitLength);
        if (!\is_array($items)) {
            throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\ShouldNotHappenException();
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
    private static function createConstantArrayFrom(array $constantArray, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantArrayType
    {
        $keyTypes = [];
        $valueTypes = [];
        $isList = \true;
        $i = 0;
        foreach ($constantArray as $key => $value) {
            $keyType = $scope->getTypeFromValue($key);
            if (!$keyType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantIntegerType) {
                throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\ShouldNotHappenException();
            }
            $keyTypes[] = $keyType;
            $valueTypes[] = $scope->getTypeFromValue($value);
            $isList = $isList && $key === $i;
            $i++;
        }
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantArrayType($keyTypes, $valueTypes, $isList ? $i : 0);
    }
}
