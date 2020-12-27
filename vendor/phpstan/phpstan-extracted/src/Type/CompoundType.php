<?php

declare (strict_types=1);
namespace PHPStan\Type;

use RectorPrefix20201227\PHPStan\TrinaryLogic;
interface CompoundType extends \PHPStan\Type\Type
{
    public function isSubTypeOf(\PHPStan\Type\Type $otherType) : \RectorPrefix20201227\PHPStan\TrinaryLogic;
    public function isAcceptedBy(\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \RectorPrefix20201227\PHPStan\TrinaryLogic;
    public function isGreaterThan(\PHPStan\Type\Type $otherType, bool $orEqual = \false) : \RectorPrefix20201227\PHPStan\TrinaryLogic;
}
