<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Php;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ConstantType;
use _PhpScoperb75b35f52b74\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntegerType;
use _PhpScoperb75b35f52b74\PHPStan\Type\NullType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator;
final class ParseUrlFunctionDynamicReturnTypeExtension implements \_PhpScoperb75b35f52b74\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    /** @var array<int,Type>|null */
    private $componentTypesPairedConstants = null;
    /** @var array<string,Type>|null */
    private $componentTypesPairedStrings = null;
    /** @var Type|null */
    private $allComponentsTogetherType = null;
    public function isFunctionSupported(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'parse_url';
    }
    public function getTypeFromFunctionCall(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $defaultReturnType = \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if (\count($functionCall->args) < 1) {
            return $defaultReturnType;
        }
        $this->cacheReturnTypes();
        $urlType = $scope->getType($functionCall->args[0]->value);
        if (\count($functionCall->args) > 1) {
            $componentType = $scope->getType($functionCall->args[1]->value);
            if (!$componentType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ConstantType) {
                return $this->createAllComponentsReturnType();
            }
            $componentType = $componentType->toInteger();
            if (!$componentType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType) {
                throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
            }
        } else {
            $componentType = new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType(-1);
        }
        if ($urlType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType) {
            try {
                $result = @\parse_url($urlType->getValue(), $componentType->getValue());
            } catch (\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\ValueError $e) {
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType(\false);
            }
            return $scope->getTypeFromValue($result);
        }
        if ($componentType->getValue() === -1) {
            return $this->createAllComponentsReturnType();
        }
        return $this->componentTypesPairedConstants[$componentType->getValue()] ?? new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType(\false);
    }
    private function createAllComponentsReturnType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if ($this->allComponentsTogetherType === null) {
            $returnTypes = [new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType(\false)];
            $builder = \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
            if ($this->componentTypesPairedStrings === null) {
                throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
            }
            foreach ($this->componentTypesPairedStrings as $componentName => $componentValueType) {
                $builder->setOffsetValueType(new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType($componentName), $componentValueType, \true);
            }
            $returnTypes[] = $builder->getArray();
            $this->allComponentsTogetherType = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union(...$returnTypes);
        }
        return $this->allComponentsTogetherType;
    }
    private function cacheReturnTypes() : void
    {
        if ($this->componentTypesPairedConstants !== null) {
            return;
        }
        $string = new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType();
        $integer = new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType();
        $false = new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType(\false);
        $null = new \_PhpScoperb75b35f52b74\PHPStan\Type\NullType();
        $stringOrFalseOrNull = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union($string, $false, $null);
        $integerOrFalseOrNull = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union($integer, $false, $null);
        $this->componentTypesPairedConstants = [\PHP_URL_SCHEME => $stringOrFalseOrNull, \PHP_URL_HOST => $stringOrFalseOrNull, \PHP_URL_PORT => $integerOrFalseOrNull, \PHP_URL_USER => $stringOrFalseOrNull, \PHP_URL_PASS => $stringOrFalseOrNull, \PHP_URL_PATH => $stringOrFalseOrNull, \PHP_URL_QUERY => $stringOrFalseOrNull, \PHP_URL_FRAGMENT => $stringOrFalseOrNull];
        $this->componentTypesPairedStrings = ['scheme' => $string, 'host' => $string, 'port' => $integer, 'user' => $string, 'pass' => $string, 'path' => $string, 'query' => $string, 'fragment' => $string];
    }
}
