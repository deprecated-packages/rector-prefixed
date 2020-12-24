<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\Mapper;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PHPStan\Type\ArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\BooleanType;
use _PhpScoper0a6b37af0871\PHPStan\Type\CallableType;
use _PhpScoper0a6b37af0871\PHPStan\Type\FloatType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntegerType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IterableType;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\NullType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ResourceType;
use _PhpScoper0a6b37af0871\PHPStan\Type\StringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\VoidType;
final class ScalarStringToTypeMapper
{
    /**
     * @var string[][]
     */
    private const SCALAR_NAME_BY_TYPE = [\_PhpScoper0a6b37af0871\PHPStan\Type\StringType::class => ['string'], \_PhpScoper0a6b37af0871\PHPStan\Type\FloatType::class => ['float', 'real', 'double'], \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType::class => ['int', 'integer'], \_PhpScoper0a6b37af0871\PHPStan\Type\BooleanType::class => ['false', 'true', 'bool', 'boolean'], \_PhpScoper0a6b37af0871\PHPStan\Type\NullType::class => ['null'], \_PhpScoper0a6b37af0871\PHPStan\Type\VoidType::class => ['void'], \_PhpScoper0a6b37af0871\PHPStan\Type\ResourceType::class => ['resource'], \_PhpScoper0a6b37af0871\PHPStan\Type\CallableType::class => ['callback', 'callable'], \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectWithoutClassType::class => ['object']];
    public function mapScalarStringToType(string $scalarName) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $loweredScalarName = \_PhpScoper0a6b37af0871\Nette\Utils\Strings::lower($scalarName);
        foreach (self::SCALAR_NAME_BY_TYPE as $objectType => $scalarNames) {
            if (!\in_array($loweredScalarName, $scalarNames, \true)) {
                continue;
            }
            return new $objectType();
        }
        if ($loweredScalarName === 'array') {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType());
        }
        if ($loweredScalarName === 'iterable') {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\IterableType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType());
        }
        if ($loweredScalarName === 'mixed') {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(\true);
        }
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
    }
}
