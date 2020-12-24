<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection\SignatureMap;

use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionVariant;
use _PhpScopere8e811afab72\PHPStan\Reflection\Native\NativeFunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\Native\NativeParameterReflection;
use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\BooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\FloatType;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\NullType;
use _PhpScopere8e811afab72\PHPStan\Type\StringAlwaysAcceptingObjectWithToStringType;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
class NativeFunctionReflectionProvider
{
    /** @var NativeFunctionReflection[] */
    private static $functionMap = [];
    /** @var \PHPStan\Reflection\SignatureMap\SignatureMapProvider */
    private $signatureMapProvider;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Reflection\SignatureMap\SignatureMapProvider $signatureMapProvider)
    {
        $this->signatureMapProvider = $signatureMapProvider;
    }
    public function findFunctionReflection(string $functionName) : ?\_PhpScopere8e811afab72\PHPStan\Reflection\Native\NativeFunctionReflection
    {
        $lowerCasedFunctionName = \strtolower($functionName);
        if (isset(self::$functionMap[$lowerCasedFunctionName])) {
            return self::$functionMap[$lowerCasedFunctionName];
        }
        if (!$this->signatureMapProvider->hasFunctionSignature($lowerCasedFunctionName)) {
            return null;
        }
        $variants = [];
        $i = 0;
        while ($this->signatureMapProvider->hasFunctionSignature($lowerCasedFunctionName, $i)) {
            $functionSignature = $this->signatureMapProvider->getFunctionSignature($lowerCasedFunctionName, null, $i);
            $returnType = $functionSignature->getReturnType();
            $variants[] = new \_PhpScopere8e811afab72\PHPStan\Reflection\FunctionVariant(\_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap::createEmpty(), null, \array_map(static function (\_PhpScopere8e811afab72\PHPStan\Reflection\SignatureMap\ParameterSignature $parameterSignature) use($lowerCasedFunctionName) : NativeParameterReflection {
                $type = $parameterSignature->getType();
                if ($parameterSignature->getName() === 'values' && ($lowerCasedFunctionName === 'printf' || $lowerCasedFunctionName === 'sprintf')) {
                    $type = new \_PhpScopere8e811afab72\PHPStan\Type\UnionType([new \_PhpScopere8e811afab72\PHPStan\Type\StringAlwaysAcceptingObjectWithToStringType(), new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(), new \_PhpScopere8e811afab72\PHPStan\Type\FloatType(), new \_PhpScopere8e811afab72\PHPStan\Type\NullType(), new \_PhpScopere8e811afab72\PHPStan\Type\BooleanType()]);
                }
                return new \_PhpScopere8e811afab72\PHPStan\Reflection\Native\NativeParameterReflection($parameterSignature->getName(), $parameterSignature->isOptional(), $type, $parameterSignature->passedByReference(), $parameterSignature->isVariadic(), null);
            }, $functionSignature->getParameters()), $functionSignature->isVariadic(), $returnType);
            $i++;
        }
        if ($this->signatureMapProvider->hasFunctionMetadata($lowerCasedFunctionName)) {
            $hasSideEffects = \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createFromBoolean($this->signatureMapProvider->getFunctionMetadata($lowerCasedFunctionName)['hasSideEffects']);
        } else {
            $hasSideEffects = \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
        }
        $functionReflection = new \_PhpScopere8e811afab72\PHPStan\Reflection\Native\NativeFunctionReflection($lowerCasedFunctionName, $variants, null, $hasSideEffects);
        self::$functionMap[$lowerCasedFunctionName] = $functionReflection;
        return $functionReflection;
    }
}
