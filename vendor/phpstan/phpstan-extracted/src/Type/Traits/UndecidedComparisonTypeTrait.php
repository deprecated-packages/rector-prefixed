<?php

declare (strict_types=1);
namespace PHPStan\Type\Traits;

use PHPStan\TrinaryLogic;
use PHPStan\Type\Type;
trait UndecidedComparisonTypeTrait
{
    public function isSmallerThan(\PHPStan\Type\Type $otherType, bool $orEqual = \false) : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createMaybe();
    }
}
