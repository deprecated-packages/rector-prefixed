<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DeadCode\Comparator\Parameter;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParameterReflection;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantFloatType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType;
use _PhpScopere8e811afab72\PHPStan\Type\ConstantType;
use _PhpScopere8e811afab72\PHPStan\Type\NullType;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Value\ValueResolver;
final class ParameterDefaultsComparator
{
    /**
     * @var ValueResolver
     */
    private $valueResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver)
    {
        $this->valueResolver = $valueResolver;
    }
    public function areDefaultValuesDifferent(\_PhpScopere8e811afab72\PHPStan\Reflection\ParameterReflection $parameterReflection, \_PhpScopere8e811afab72\PhpParser\Node\Param $param) : bool
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
    private function isMutuallyExclusiveNull(\_PhpScopere8e811afab72\PHPStan\Reflection\ParameterReflection $parameterReflection, \_PhpScopere8e811afab72\PhpParser\Node\Param $param) : bool
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
    private function resolveParameterReflectionDefaultValue(\_PhpScopere8e811afab72\PHPStan\Reflection\ParameterReflection $parameterReflection)
    {
        $defaultValue = $parameterReflection->getDefaultValue();
        if (!$defaultValue instanceof \_PhpScopere8e811afab72\PHPStan\Type\ConstantType) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        if ($defaultValue instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType) {
            return $defaultValue->getAllArrays();
        }
        /** @var ConstantStringType|ConstantIntegerType|ConstantFloatType|ConstantBooleanType|NullType $defaultValue */
        return $defaultValue->getValue();
    }
}
