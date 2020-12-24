<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Traits;

use _PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
trait UndecidedComparisonCompoundTypeTrait
{
    use UndecidedComparisonTypeTrait;
    public function isGreaterThan(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $otherType, bool $orEqual = \false) : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createMaybe();
    }
}
