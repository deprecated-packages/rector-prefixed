<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\DeadCode\Comparator\Parameter;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Param;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ParameterReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantFloatType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ConstantType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\NullType;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Value\ValueResolver;
final class ParameterDefaultsComparator
{
    /**
     * @var ValueResolver
     */
    private $valueResolver;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver)
    {
        $this->valueResolver = $valueResolver;
    }
    public function areDefaultValuesDifferent(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParameterReflection $parameterReflection, \_PhpScoper0a2ac50786fa\PhpParser\Node\Param $param) : bool
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
    private function isMutuallyExclusiveNull(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParameterReflection $parameterReflection, \_PhpScoper0a2ac50786fa\PhpParser\Node\Param $param) : bool
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
    private function resolveParameterReflectionDefaultValue(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParameterReflection $parameterReflection)
    {
        $defaultValue = $parameterReflection->getDefaultValue();
        if (!$defaultValue instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ConstantType) {
            throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException();
        }
        if ($defaultValue instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayType) {
            return $defaultValue->getAllArrays();
        }
        /** @var ConstantStringType|ConstantIntegerType|ConstantFloatType|ConstantBooleanType|NullType $defaultValue */
        return $defaultValue->getValue();
    }
}
