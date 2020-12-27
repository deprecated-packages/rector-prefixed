<?php

declare (strict_types=1);
namespace PHPStan\Reflection\SignatureMap;

use PHPStan\Reflection\FunctionVariant;
use PHPStan\Reflection\Native\NativeFunctionReflection;
use PHPStan\Reflection\Native\NativeParameterReflection;
use PHPStan\TrinaryLogic;
use PHPStan\Type\BooleanType;
use PHPStan\Type\FloatType;
use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\IntegerType;
use PHPStan\Type\NullType;
use PHPStan\Type\StringAlwaysAcceptingObjectWithToStringType;
use PHPStan\Type\UnionType;
class NativeFunctionReflectionProvider
{
    /** @var NativeFunctionReflection[] */
    private static $functionMap = [];
    /** @var \PHPStan\Reflection\SignatureMap\SignatureMapProvider */
    private $signatureMapProvider;
    public function __construct(\PHPStan\Reflection\SignatureMap\SignatureMapProvider $signatureMapProvider)
    {
        $this->signatureMapProvider = $signatureMapProvider;
    }
    public function findFunctionReflection(string $functionName) : ?\PHPStan\Reflection\Native\NativeFunctionReflection
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
            $variants[] = new \PHPStan\Reflection\FunctionVariant(\PHPStan\Type\Generic\TemplateTypeMap::createEmpty(), null, \array_map(static function (\PHPStan\Reflection\SignatureMap\ParameterSignature $parameterSignature) use($lowerCasedFunctionName) : NativeParameterReflection {
                $type = $parameterSignature->getType();
                if ($parameterSignature->getName() === 'values' && ($lowerCasedFunctionName === 'printf' || $lowerCasedFunctionName === 'sprintf')) {
                    $type = new \PHPStan\Type\UnionType([new \PHPStan\Type\StringAlwaysAcceptingObjectWithToStringType(), new \PHPStan\Type\IntegerType(), new \PHPStan\Type\FloatType(), new \PHPStan\Type\NullType(), new \PHPStan\Type\BooleanType()]);
                }
                return new \PHPStan\Reflection\Native\NativeParameterReflection($parameterSignature->getName(), $parameterSignature->isOptional(), $type, $parameterSignature->passedByReference(), $parameterSignature->isVariadic(), null);
            }, $functionSignature->getParameters()), $functionSignature->isVariadic(), $returnType);
            $i++;
        }
        if ($this->signatureMapProvider->hasFunctionMetadata($lowerCasedFunctionName)) {
            $hasSideEffects = \PHPStan\TrinaryLogic::createFromBoolean($this->signatureMapProvider->getFunctionMetadata($lowerCasedFunctionName)['hasSideEffects']);
        } else {
            $hasSideEffects = \PHPStan\TrinaryLogic::createMaybe();
        }
        $functionReflection = new \PHPStan\Reflection\Native\NativeFunctionReflection($lowerCasedFunctionName, $variants, null, $hasSideEffects);
        self::$functionMap[$lowerCasedFunctionName] = $functionReflection;
        return $functionReflection;
    }
}
