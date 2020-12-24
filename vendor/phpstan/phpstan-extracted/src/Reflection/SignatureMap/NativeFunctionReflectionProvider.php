<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Reflection\SignatureMap;

use _PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionVariant;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\Native\NativeFunctionReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\Native\NativeParameterReflection;
use _PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
use _PhpScoper0a6b37af0871\PHPStan\Type\BooleanType;
use _PhpScoper0a6b37af0871\PHPStan\Type\FloatType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntegerType;
use _PhpScoper0a6b37af0871\PHPStan\Type\NullType;
use _PhpScoper0a6b37af0871\PHPStan\Type\StringAlwaysAcceptingObjectWithToStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\UnionType;
class NativeFunctionReflectionProvider
{
    /** @var NativeFunctionReflection[] */
    private static $functionMap = [];
    /** @var \PHPStan\Reflection\SignatureMap\SignatureMapProvider */
    private $signatureMapProvider;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Reflection\SignatureMap\SignatureMapProvider $signatureMapProvider)
    {
        $this->signatureMapProvider = $signatureMapProvider;
    }
    public function findFunctionReflection(string $functionName) : ?\_PhpScoper0a6b37af0871\PHPStan\Reflection\Native\NativeFunctionReflection
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
            $variants[] = new \_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionVariant(\_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeMap::createEmpty(), null, \array_map(static function (\_PhpScoper0a6b37af0871\PHPStan\Reflection\SignatureMap\ParameterSignature $parameterSignature) use($lowerCasedFunctionName) : NativeParameterReflection {
                $type = $parameterSignature->getType();
                if ($parameterSignature->getName() === 'values' && ($lowerCasedFunctionName === 'printf' || $lowerCasedFunctionName === 'sprintf')) {
                    $type = new \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType([new \_PhpScoper0a6b37af0871\PHPStan\Type\StringAlwaysAcceptingObjectWithToStringType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\FloatType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\NullType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\BooleanType()]);
                }
                return new \_PhpScoper0a6b37af0871\PHPStan\Reflection\Native\NativeParameterReflection($parameterSignature->getName(), $parameterSignature->isOptional(), $type, $parameterSignature->passedByReference(), $parameterSignature->isVariadic(), null);
            }, $functionSignature->getParameters()), $functionSignature->isVariadic(), $returnType);
            $i++;
        }
        if ($this->signatureMapProvider->hasFunctionMetadata($lowerCasedFunctionName)) {
            $hasSideEffects = \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createFromBoolean($this->signatureMapProvider->getFunctionMetadata($lowerCasedFunctionName)['hasSideEffects']);
        } else {
            $hasSideEffects = \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createMaybe();
        }
        $functionReflection = new \_PhpScoper0a6b37af0871\PHPStan\Reflection\Native\NativeFunctionReflection($lowerCasedFunctionName, $variants, null, $hasSideEffects);
        self::$functionMap[$lowerCasedFunctionName] = $functionReflection;
        return $functionReflection;
    }
}
