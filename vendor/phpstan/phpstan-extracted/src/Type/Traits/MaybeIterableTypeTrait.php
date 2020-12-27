<?php

declare (strict_types=1);
namespace PHPStan\Type\Traits;

use PHPStan\TrinaryLogic;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
trait MaybeIterableTypeTrait
{
    public function isIterable() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createMaybe();
    }
    public function isIterableAtLeastOnce() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createMaybe();
    }
    public function getIterableKeyType() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\MixedType();
    }
    public function getIterableValueType() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\MixedType();
    }
}
