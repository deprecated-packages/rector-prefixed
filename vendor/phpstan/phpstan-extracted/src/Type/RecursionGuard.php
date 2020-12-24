<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type;

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
    public static function run(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, callable $callback) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $key = $type->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::value());
        if (isset(self::$context[$key])) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
        }
        try {
            self::$context[$key] = \true;
            return $callback();
        } finally {
            unset(self::$context[$key]);
        }
    }
}
