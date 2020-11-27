<?php

namespace _PhpScoper006a73f0e455\Bug2612;

use function PHPStan\Analyser\assertType;
class TypeFactory
{
    /**
     * @phpstan-template T
     * @phpstan-param T $type
     * @phpstan-return T
     */
    public static function singleton($type)
    {
        return $type;
    }
}
class StringType
{
    public static function create(string $value) : self
    {
        $valueType = new static();
        $result = \_PhpScoper006a73f0e455\Bug2612\TypeFactory::singleton($valueType);
        \PHPStan\Analyser\assertType('_PhpScoper006a73f0e455\\Bug2612\\StringType', $result);
        return $result;
    }
}
