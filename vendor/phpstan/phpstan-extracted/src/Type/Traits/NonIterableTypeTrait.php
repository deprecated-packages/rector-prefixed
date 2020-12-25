<?php

declare (strict_types=1);
namespace PHPStan\Type\Traits;

use PHPStan\TrinaryLogic;
use PHPStan\Type\ErrorType;
use PHPStan\Type\Type;
trait NonIterableTypeTrait
{
    public function isIterable() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function isIterableAtLeastOnce() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function getIterableKeyType() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    public function getIterableValueType() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
}
