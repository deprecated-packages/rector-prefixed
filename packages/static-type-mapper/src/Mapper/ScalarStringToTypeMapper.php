<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\Mapper;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\BooleanType;
use _PhpScoperb75b35f52b74\PHPStan\Type\CallableType;
use _PhpScoperb75b35f52b74\PHPStan\Type\FloatType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntegerType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IterableType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\NullType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ResourceType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\VoidType;
final class ScalarStringToTypeMapper
{
    /**
     * @var string[][]
     */
    private const SCALAR_NAME_BY_TYPE = [\_PhpScoperb75b35f52b74\PHPStan\Type\StringType::class => ['string'], \_PhpScoperb75b35f52b74\PHPStan\Type\FloatType::class => ['float', 'real', 'double'], \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType::class => ['int', 'integer'], \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType::class => ['false', 'true', 'bool', 'boolean'], \_PhpScoperb75b35f52b74\PHPStan\Type\NullType::class => ['null'], \_PhpScoperb75b35f52b74\PHPStan\Type\VoidType::class => ['void'], \_PhpScoperb75b35f52b74\PHPStan\Type\ResourceType::class => ['resource'], \_PhpScoperb75b35f52b74\PHPStan\Type\CallableType::class => ['callback', 'callable'], \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType::class => ['object']];
    public function mapScalarStringToType(string $scalarName) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $loweredScalarName = \_PhpScoperb75b35f52b74\Nette\Utils\Strings::lower($scalarName);
        foreach (self::SCALAR_NAME_BY_TYPE as $objectType => $scalarNames) {
            if (!\in_array($loweredScalarName, $scalarNames, \true)) {
                continue;
            }
            return new $objectType();
        }
        if ($loweredScalarName === 'array') {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType(new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType());
        }
        if ($loweredScalarName === 'iterable') {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\IterableType(new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType());
        }
        if ($loweredScalarName === 'mixed') {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(\true);
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
    }
}
