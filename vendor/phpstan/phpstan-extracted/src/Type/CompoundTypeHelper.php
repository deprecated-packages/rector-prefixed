<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type;

use _PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
class CompoundTypeHelper
{
    public static function accepts(\_PhpScoper0a6b37af0871\PHPStan\Type\CompoundType $compoundType, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $otherType, bool $strictTypes) : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return $compoundType->isAcceptedBy($otherType, $strictTypes);
    }
}
