<?php

namespace _PhpScoper88fe6e0ad041\Bug2612;

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
        $result = \_PhpScoper88fe6e0ad041\Bug2612\TypeFactory::singleton($valueType);
        \PHPStan\Analyser\assertType('_PhpScoper88fe6e0ad041\\Bug2612\\StringType', $result);
        return $result;
    }
}
