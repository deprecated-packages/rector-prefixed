<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\TrinaryLogic;
class CompoundTypeHelper
{
    public static function accepts(\PHPStan\Type\CompoundType $compoundType, \PHPStan\Type\Type $otherType, bool $strictTypes) : \PHPStan\TrinaryLogic
    {
        return $compoundType->isAcceptedBy($otherType, $strictTypes);
    }
}
