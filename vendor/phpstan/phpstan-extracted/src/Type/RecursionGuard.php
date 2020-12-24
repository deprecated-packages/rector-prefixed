<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type;

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
    public static function run(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, callable $callback) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $key = $type->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::value());
        if (isset(self::$context[$key])) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
        }
        try {
            self::$context[$key] = \true;
            return $callback();
        } finally {
            unset(self::$context[$key]);
        }
    }
}
