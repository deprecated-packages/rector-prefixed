<?php

declare (strict_types=1);
namespace PHPStan\Type;

use RectorPrefix20201227\PHPStan\TrinaryLogic;
class CompoundTypeHelper
{
    public static function accepts(\PHPStan\Type\CompoundType $compoundType, \PHPStan\Type\Type $otherType, bool $strictTypes) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $compoundType->isAcceptedBy($otherType, $strictTypes);
    }
}
