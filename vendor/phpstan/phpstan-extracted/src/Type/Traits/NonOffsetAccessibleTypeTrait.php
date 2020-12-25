<?php

declare (strict_types=1);
namespace PHPStan\Type\Traits;

use PHPStan\TrinaryLogic;
use PHPStan\Type\ErrorType;
use PHPStan\Type\Type;
trait NonOffsetAccessibleTypeTrait
{
    public function isOffsetAccessible() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function hasOffsetValueType(\PHPStan\Type\Type $offsetType) : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function getOffsetValueType(\PHPStan\Type\Type $offsetType) : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    public function setOffsetValueType(?\PHPStan\Type\Type $offsetType, \PHPStan\Type\Type $valueType) : \PHPStan\Type\Type
    {
        return $this;
    }
}
