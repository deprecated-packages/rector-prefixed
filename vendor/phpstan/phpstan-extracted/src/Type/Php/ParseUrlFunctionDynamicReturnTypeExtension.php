<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Php;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ConstantType;
use _PhpScoper0a6b37af0871\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntegerType;
use _PhpScoper0a6b37af0871\PHPStan\Type\NullType;
use _PhpScoper0a6b37af0871\PHPStan\Type\StringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator;
final class ParseUrlFunctionDynamicReturnTypeExtension implements \_PhpScoper0a6b37af0871\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    /** @var array<int,Type>|null */
    private $componentTypesPairedConstants = null;
    /** @var array<string,Type>|null */
    private $componentTypesPairedStrings = null;
    /** @var Type|null */
    private $allComponentsTogetherType = null;
    public function isFunctionSupported(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'parse_url';
    }
    public function getTypeFromFunctionCall(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $defaultReturnType = \_PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if (\count($functionCall->args) < 1) {
            return $defaultReturnType;
        }
        $this->cacheReturnTypes();
        $urlType = $scope->getType($functionCall->args[0]->value);
        if (\count($functionCall->args) > 1) {
            $componentType = $scope->getType($functionCall->args[1]->value);
            if (!$componentType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ConstantType) {
                return $this->createAllComponentsReturnType();
            }
            $componentType = $componentType->toInteger();
            if (!$componentType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType) {
                throw new \_PhpScoper0a6b37af0871\PHPStan\ShouldNotHappenException();
            }
        } else {
            $componentType = new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType(-1);
        }
        if ($urlType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType) {
            try {
                $result = @\parse_url($urlType->getValue(), $componentType->getValue());
            } catch (\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\ValueError $e) {
                return new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType(\false);
            }
            return $scope->getTypeFromValue($result);
        }
        if ($componentType->getValue() === -1) {
            return $this->createAllComponentsReturnType();
        }
        return $this->componentTypesPairedConstants[$componentType->getValue()] ?? new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType(\false);
    }
    private function createAllComponentsReturnType() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        if ($this->allComponentsTogetherType === null) {
            $returnTypes = [new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType(\false)];
            $builder = \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
            if ($this->componentTypesPairedStrings === null) {
                throw new \_PhpScoper0a6b37af0871\PHPStan\ShouldNotHappenException();
            }
            foreach ($this->componentTypesPairedStrings as $componentName => $componentValueType) {
                $builder->setOffsetValueType(new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType($componentName), $componentValueType, \true);
            }
            $returnTypes[] = $builder->getArray();
            $this->allComponentsTogetherType = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::union(...$returnTypes);
        }
        return $this->allComponentsTogetherType;
    }
    private function cacheReturnTypes() : void
    {
        if ($this->componentTypesPairedConstants !== null) {
            return;
        }
        $string = new \_PhpScoper0a6b37af0871\PHPStan\Type\StringType();
        $integer = new \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType();
        $false = new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType(\false);
        $null = new \_PhpScoper0a6b37af0871\PHPStan\Type\NullType();
        $stringOrFalseOrNull = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::union($string, $false, $null);
        $integerOrFalseOrNull = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::union($integer, $false, $null);
        $this->componentTypesPairedConstants = [\PHP_URL_SCHEME => $stringOrFalseOrNull, \PHP_URL_HOST => $stringOrFalseOrNull, \PHP_URL_PORT => $integerOrFalseOrNull, \PHP_URL_USER => $stringOrFalseOrNull, \PHP_URL_PASS => $stringOrFalseOrNull, \PHP_URL_PATH => $stringOrFalseOrNull, \PHP_URL_QUERY => $stringOrFalseOrNull, \PHP_URL_FRAGMENT => $stringOrFalseOrNull];
        $this->componentTypesPairedStrings = ['scheme' => $string, 'host' => $string, 'port' => $integer, 'user' => $string, 'pass' => $string, 'path' => $string, 'query' => $string, 'fragment' => $string];
    }
}
