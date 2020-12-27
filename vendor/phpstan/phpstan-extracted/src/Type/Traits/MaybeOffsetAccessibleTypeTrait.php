<?php

declare (strict_types=1);
namespace PHPStan\Type\Traits;

use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
trait MaybeOffsetAccessibleTypeTrait
{
    public function isOffsetAccessible() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
    }
    public function hasOffsetValueType(\PHPStan\Type\Type $offsetType) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getOffsetValueType(\PHPStan\Type\Type $offsetType) : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\MixedType();
    }
    public function setOffsetValueType(?\PHPStan\Type\Type $offsetType, \PHPStan\Type\Type $valueType) : \PHPStan\Type\Type
    {
        return $this;
    }
}
