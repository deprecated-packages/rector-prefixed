<?php

declare (strict_types=1);
namespace PHPStan\Type\Traits;

use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\Type;
trait UndecidedComparisonTypeTrait
{
    public function isSmallerThan(\PHPStan\Type\Type $otherType, bool $orEqual = \false) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
    }
}
