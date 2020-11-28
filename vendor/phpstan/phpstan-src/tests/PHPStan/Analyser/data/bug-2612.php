<?php

namespace _PhpScoperabd03f0baf05\Bug2612;

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
        $result = \_PhpScoperabd03f0baf05\Bug2612\TypeFactory::singleton($valueType);
        \PHPStan\Analyser\assertType('_PhpScoperabd03f0baf05\\Bug2612\\StringType', $result);
        return $result;
    }
}
