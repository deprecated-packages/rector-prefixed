<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type;

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
    public static function run(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, callable $callback) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $key = $type->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::value());
        if (isset(self::$context[$key])) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
        }
        try {
            self::$context[$key] = \true;
            return $callback();
        } finally {
            unset(self::$context[$key]);
        }
    }
}
