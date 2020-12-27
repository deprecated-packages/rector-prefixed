<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\ConstantType;
use PHPStan\Type\DynamicFunctionReturnTypeExtension;
use PHPStan\Type\IntegerType;
use PHPStan\Type\NullType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
final class ParseUrlFunctionDynamicReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    /** @var array<int,Type>|null */
    private $componentTypesPairedConstants = null;
    /** @var array<string,Type>|null */
    private $componentTypesPairedStrings = null;
    /** @var Type|null */
    private $allComponentsTogetherType = null;
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'parse_url';
    }
    public function getTypeFromFunctionCall(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $defaultReturnType = \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if (\count($functionCall->args) < 1) {
            return $defaultReturnType;
        }
        $this->cacheReturnTypes();
        $urlType = $scope->getType($functionCall->args[0]->value);
        if (\count($functionCall->args) > 1) {
            $componentType = $scope->getType($functionCall->args[1]->value);
            if (!$componentType instanceof \PHPStan\Type\ConstantType) {
                return $this->createAllComponentsReturnType();
            }
            $componentType = $componentType->toInteger();
            if (!$componentType instanceof \PHPStan\Type\Constant\ConstantIntegerType) {
                throw new \PHPStan\ShouldNotHappenException();
            }
        } else {
            $componentType = new \PHPStan\Type\Constant\ConstantIntegerType(-1);
        }
        if ($urlType instanceof \PHPStan\Type\Constant\ConstantStringType) {
            try {
                $result = @\parse_url($urlType->getValue(), $componentType->getValue());
            } catch (\_HumbugBox221ad6f1b81f\ValueError $e) {
                return new \PHPStan\Type\Constant\ConstantBooleanType(\false);
            }
            return $scope->getTypeFromValue($result);
        }
        if ($componentType->getValue() === -1) {
            return $this->createAllComponentsReturnType();
        }
        return $this->componentTypesPairedConstants[$componentType->getValue()] ?? new \PHPStan\Type\Constant\ConstantBooleanType(\false);
    }
    private function createAllComponentsReturnType() : \PHPStan\Type\Type
    {
        if ($this->allComponentsTogetherType === null) {
            $returnTypes = [new \PHPStan\Type\Constant\ConstantBooleanType(\false)];
            $builder = \PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
            if ($this->componentTypesPairedStrings === null) {
                throw new \PHPStan\ShouldNotHappenException();
            }
            foreach ($this->componentTypesPairedStrings as $componentName => $componentValueType) {
                $builder->setOffsetValueType(new \PHPStan\Type\Constant\ConstantStringType($componentName), $componentValueType, \true);
            }
            $returnTypes[] = $builder->getArray();
            $this->allComponentsTogetherType = \PHPStan\Type\TypeCombinator::union(...$returnTypes);
        }
        return $this->allComponentsTogetherType;
    }
    private function cacheReturnTypes() : void
    {
        if ($this->componentTypesPairedConstants !== null) {
            return;
        }
        $string = new \PHPStan\Type\StringType();
        $integer = new \PHPStan\Type\IntegerType();
        $false = new \PHPStan\Type\Constant\ConstantBooleanType(\false);
        $null = new \PHPStan\Type\NullType();
        $stringOrFalseOrNull = \PHPStan\Type\TypeCombinator::union($string, $false, $null);
        $integerOrFalseOrNull = \PHPStan\Type\TypeCombinator::union($integer, $false, $null);
        $this->componentTypesPairedConstants = [\PHP_URL_SCHEME => $stringOrFalseOrNull, \PHP_URL_HOST => $stringOrFalseOrNull, \PHP_URL_PORT => $integerOrFalseOrNull, \PHP_URL_USER => $stringOrFalseOrNull, \PHP_URL_PASS => $stringOrFalseOrNull, \PHP_URL_PATH => $stringOrFalseOrNull, \PHP_URL_QUERY => $stringOrFalseOrNull, \PHP_URL_FRAGMENT => $stringOrFalseOrNull];
        $this->componentTypesPairedStrings = ['scheme' => $string, 'host' => $string, 'port' => $integer, 'user' => $string, 'pass' => $string, 'path' => $string, 'query' => $string, 'fragment' => $string];
    }
}
