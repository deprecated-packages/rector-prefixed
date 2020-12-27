<?php

declare (strict_types=1);
namespace PHPStan\Type\Traits;

use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\Type;
trait UndecidedComparisonCompoundTypeTrait
{
    use UndecidedComparisonTypeTrait;
    public function isGreaterThan(\PHPStan\Type\Type $otherType, bool $orEqual = \false) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
    }
}
