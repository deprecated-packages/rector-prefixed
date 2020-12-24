<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Accessory\AccessoryNumericStringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Accessory\NonEmptyArrayType;
class VerbosityLevel
{
    private const TYPE_ONLY = 1;
    private const VALUE = 2;
    private const PRECISE = 3;
    private const CACHE = 4;
    /** @var self[] */
    private static $registry;
    /** @var int */
    private $value;
    private function __construct(int $value)
    {
        $this->value = $value;
    }
    private static function create(int $value) : self
    {
        self::$registry[$value] = self::$registry[$value] ?? new self($value);
        return self::$registry[$value];
    }
    public static function typeOnly() : self
    {
        return self::create(self::TYPE_ONLY);
    }
    public static function value() : self
    {
        return self::create(self::VALUE);
    }
    public static function precise() : self
    {
        return self::create(self::PRECISE);
    }
    public static function cache() : self
    {
        return self::create(self::CACHE);
    }
    public static function getRecommendedLevelByType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : self
    {
        $moreVerbose = \false;
        \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeTraverser::map($type, static function (\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, callable $traverse) use(&$moreVerbose) : Type {
            if ($type->isCallable()->yes()) {
                $moreVerbose = \true;
                return $type;
            }
            if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ConstantType && !$type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\NullType) {
                $moreVerbose = \true;
                return $type;
            }
            if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Accessory\AccessoryNumericStringType) {
                $moreVerbose = \true;
                return $type;
            }
            if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Accessory\NonEmptyArrayType) {
                $moreVerbose = \true;
                return $type;
            }
            return $traverse($type);
        });
        return $moreVerbose ? self::value() : self::typeOnly();
    }
    /**
     * @param callable(): string $typeOnlyCallback
     * @param callable(): string $valueCallback
     * @param callable(): string|null $preciseCallback
     * @param callable(): string|null $cacheCallback
     * @return string
     */
    public function handle(callable $typeOnlyCallback, callable $valueCallback, ?callable $preciseCallback = null, ?callable $cacheCallback = null) : string
    {
        if ($this->value === self::TYPE_ONLY) {
            return $typeOnlyCallback();
        }
        if ($this->value === self::VALUE) {
            return $valueCallback();
        }
        if ($this->value === self::PRECISE) {
            if ($preciseCallback !== null) {
                return $preciseCallback();
            }
            return $valueCallback();
        }
        if ($this->value === self::CACHE) {
            if ($cacheCallback !== null) {
                return $cacheCallback();
            }
            if ($preciseCallback !== null) {
                return $preciseCallback();
            }
            return $valueCallback();
        }
        throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\ShouldNotHappenException();
    }
}
