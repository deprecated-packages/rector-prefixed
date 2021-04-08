<?php

declare (strict_types=1);
namespace Rector\StaticTypeMapper\Mapper;

use RectorPrefix20210408\Nette\Utils\Strings;
use PHPStan\Type\ArrayType;
use PHPStan\Type\BooleanType;
use PHPStan\Type\CallableType;
use PHPStan\Type\FloatType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\IterableType;
use PHPStan\Type\MixedType;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectWithoutClassType;
use PHPStan\Type\ResourceType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\VoidType;
use Rector\StaticTypeMapper\ValueObject\Type\FalseBooleanType;
final class ScalarStringToTypeMapper
{
    /**
     * @var array<class-string<Type>, string[]>
     */
    private const SCALAR_NAME_BY_TYPE = [\PHPStan\Type\StringType::class => ['string'], \PHPStan\Type\FloatType::class => ['float', 'real', 'double'], \PHPStan\Type\IntegerType::class => ['int', 'integer'], \Rector\StaticTypeMapper\ValueObject\Type\FalseBooleanType::class => ['false'], \PHPStan\Type\BooleanType::class => ['true', 'bool', 'boolean'], \PHPStan\Type\NullType::class => ['null'], \PHPStan\Type\VoidType::class => ['void'], \PHPStan\Type\ResourceType::class => ['resource'], \PHPStan\Type\CallableType::class => ['callback', 'callable'], \PHPStan\Type\ObjectWithoutClassType::class => ['object']];
    public function mapScalarStringToType(string $scalarName) : \PHPStan\Type\Type
    {
        $loweredScalarName = \RectorPrefix20210408\Nette\Utils\Strings::lower($scalarName);
        foreach (self::SCALAR_NAME_BY_TYPE as $objectType => $scalarNames) {
            if (!\in_array($loweredScalarName, $scalarNames, \true)) {
                continue;
            }
            return new $objectType();
        }
        if ($loweredScalarName === 'array') {
            return new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType());
        }
        if ($loweredScalarName === 'iterable') {
            return new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType());
        }
        if ($loweredScalarName === 'mixed') {
            return new \PHPStan\Type\MixedType(\true);
        }
        return new \PHPStan\Type\MixedType();
    }
}
