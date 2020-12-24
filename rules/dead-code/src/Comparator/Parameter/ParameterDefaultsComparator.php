<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DeadCode\Comparator\Parameter;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ParameterReflection;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantFloatType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ConstantType;
use _PhpScoperb75b35f52b74\PHPStan\Type\NullType;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Value\ValueResolver;
final class ParameterDefaultsComparator
{
    /**
     * @var ValueResolver
     */
    private $valueResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver)
    {
        $this->valueResolver = $valueResolver;
    }
    public function areDefaultValuesDifferent(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ParameterReflection $parameterReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Param $param) : bool
    {
        if ($parameterReflection->getDefaultValue() === null && $param->default === null) {
            return \false;
        }
        if ($this->isMutuallyExclusiveNull($parameterReflection, $param)) {
            return \true;
        }
        /** @var Expr $paramDefault */
        $paramDefault = $param->default;
        $firstParameterValue = $this->resolveParameterReflectionDefaultValue($parameterReflection);
        $secondParameterValue = $this->valueResolver->getValue($paramDefault);
        return $firstParameterValue !== $secondParameterValue;
    }
    private function isMutuallyExclusiveNull(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ParameterReflection $parameterReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Param $param) : bool
    {
        if ($parameterReflection->getDefaultValue() === null && $param->default !== null) {
            return \true;
        }
        if ($parameterReflection->getDefaultValue() === null) {
            return \false;
        }
        return $param->default === null;
    }
    /**
     * @return bool|float|int|string|mixed[]|null
     */
    private function resolveParameterReflectionDefaultValue(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ParameterReflection $parameterReflection)
    {
        $defaultValue = $parameterReflection->getDefaultValue();
        if (!$defaultValue instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ConstantType) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        if ($defaultValue instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType) {
            return $defaultValue->getAllArrays();
        }
        /** @var ConstantStringType|ConstantIntegerType|ConstantFloatType|ConstantBooleanType|NullType $defaultValue */
        return $defaultValue->getValue();
    }
}
