<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\StaticTypeMapper\Mapper;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\BooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\CallableType;
use _PhpScopere8e811afab72\PHPStan\Type\FloatType;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\IterableType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\NullType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType;
use _PhpScopere8e811afab72\PHPStan\Type\ResourceType;
use _PhpScopere8e811afab72\PHPStan\Type\StringType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\VoidType;
final class ScalarStringToTypeMapper
{
    /**
     * @var string[][]
     */
    private const SCALAR_NAME_BY_TYPE = [\_PhpScopere8e811afab72\PHPStan\Type\StringType::class => ['string'], \_PhpScopere8e811afab72\PHPStan\Type\FloatType::class => ['float', 'real', 'double'], \_PhpScopere8e811afab72\PHPStan\Type\IntegerType::class => ['int', 'integer'], \_PhpScopere8e811afab72\PHPStan\Type\BooleanType::class => ['false', 'true', 'bool', 'boolean'], \_PhpScopere8e811afab72\PHPStan\Type\NullType::class => ['null'], \_PhpScopere8e811afab72\PHPStan\Type\VoidType::class => ['void'], \_PhpScopere8e811afab72\PHPStan\Type\ResourceType::class => ['resource'], \_PhpScopere8e811afab72\PHPStan\Type\CallableType::class => ['callback', 'callable'], \_PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType::class => ['object']];
    public function mapScalarStringToType(string $scalarName) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $loweredScalarName = \_PhpScopere8e811afab72\Nette\Utils\Strings::lower($scalarName);
        foreach (self::SCALAR_NAME_BY_TYPE as $objectType => $scalarNames) {
            if (!\in_array($loweredScalarName, $scalarNames, \true)) {
                continue;
            }
            return new $objectType();
        }
        if ($loweredScalarName === 'array') {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), new \_PhpScopere8e811afab72\PHPStan\Type\MixedType());
        }
        if ($loweredScalarName === 'iterable') {
            return new \_PhpScopere8e811afab72\PHPStan\Type\IterableType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), new \_PhpScopere8e811afab72\PHPStan\Type\MixedType());
        }
        if ($loweredScalarName === 'mixed') {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(\true);
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
    }
}
