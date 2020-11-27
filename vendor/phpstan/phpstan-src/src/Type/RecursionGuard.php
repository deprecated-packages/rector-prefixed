<?php

declare (strict_types=1);
namespace PHPStan\Type;

class RecursionGuard
{
    /** @var true[] */
    private static $context = [];
    /**
     * @param Type $type
     * @param callable(): Type $callback
     *
     * @return Type
     */
    public static function run(\PHPStan\Type\Type $type, callable $callback) : \PHPStan\Type\Type
    {
        $key = $type->describe(\PHPStan\Type\VerbosityLevel::value());
        if (isset(self::$context[$key])) {
            return new \PHPStan\Type\ErrorType();
        }
        try {
            self::$context[$key] = \true;
            return $callback();
        } finally {
            unset(self::$context[$key]);
        }
    }
}
