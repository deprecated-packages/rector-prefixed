<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type;

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
    public static function run(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, callable $callback) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        $key = $type->describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel::value());
        if (isset(self::$context[$key])) {
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType();
        }
        try {
            self::$context[$key] = \true;
            return $callback();
        } finally {
            unset(self::$context[$key]);
        }
    }
}
