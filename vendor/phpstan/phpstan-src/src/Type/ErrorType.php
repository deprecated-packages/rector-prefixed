<?php

declare (strict_types=1);
namespace PHPStan\Type;

class ErrorType extends \PHPStan\Type\MixedType
{
    public function __construct()
    {
        parent::__construct();
    }
    public function describe(\PHPStan\Type\VerbosityLevel $level) : string
    {
        return $level->handle(function () use($level) : string {
            return parent::describe($level);
        }, function () use($level) : string {
            return parent::describe($level);
        }, static function () : string {
            return '*ERROR*';
        });
    }
    public function getIterableKeyType() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    public function getIterableValueType() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    public function subtract(\PHPStan\Type\Type $type) : \PHPStan\Type\Type
    {
        return new self();
    }
    public function equals(\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self;
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \PHPStan\Type\Type
    {
        return new self();
    }
}
