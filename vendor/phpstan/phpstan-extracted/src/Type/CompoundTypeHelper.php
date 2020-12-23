<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type;

use _PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
class CompoundTypeHelper
{
    public static function accepts(\_PhpScoper0a2ac50786fa\PHPStan\Type\CompoundType $compoundType, \_PhpScoper0a2ac50786fa\PHPStan\Type\Type $otherType, bool $strictTypes) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $compoundType->isAcceptedBy($otherType, $strictTypes);
    }
}
