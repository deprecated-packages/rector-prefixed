<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type;

class ErrorType extends \_PhpScopere8e811afab72\PHPStan\Type\MixedType
{
    public function __construct()
    {
        parent::__construct();
    }
    public function describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel $level) : string
    {
        return $level->handle(function () use($level) : string {
            return parent::describe($level);
        }, function () use($level) : string {
            return parent::describe($level);
        }, static function () : string {
            return '*ERROR*';
        });
    }
    public function getIterableKeyType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
    }
    public function getIterableValueType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
    }
    public function subtract(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new self();
    }
    public function equals(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self;
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new self();
    }
}
