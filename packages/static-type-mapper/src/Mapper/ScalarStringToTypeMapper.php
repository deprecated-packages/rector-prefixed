<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\Mapper;

use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\CallableType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\FloatType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\IterableType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\NullType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ResourceType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\VoidType;
final class ScalarStringToTypeMapper
{
    /**
     * @var string[][]
     */
    private const SCALAR_NAME_BY_TYPE = [\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType::class => ['string'], \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\FloatType::class => ['float', 'real', 'double'], \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType::class => ['int', 'integer'], \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType::class => ['false', 'true', 'bool', 'boolean'], \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\NullType::class => ['null'], \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VoidType::class => ['void'], \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ResourceType::class => ['resource'], \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\CallableType::class => ['callback', 'callable'], \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectWithoutClassType::class => ['object']];
    public function mapScalarStringToType(string $scalarName) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        $loweredScalarName = \_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::lower($scalarName);
        foreach (self::SCALAR_NAME_BY_TYPE as $objectType => $scalarNames) {
            if (!\in_array($loweredScalarName, $scalarNames, \true)) {
                continue;
            }
            return new $objectType();
        }
        if ($loweredScalarName === 'array') {
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType(), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType());
        }
        if ($loweredScalarName === 'iterable') {
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IterableType(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType(), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType());
        }
        if ($loweredScalarName === 'mixed') {
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType(\true);
        }
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType();
    }
}
