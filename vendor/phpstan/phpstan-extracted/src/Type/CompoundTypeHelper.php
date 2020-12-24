<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type;

use _PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
class CompoundTypeHelper
{
    public static function accepts(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\CompoundType $compoundType, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $otherType, bool $strictTypes) : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        return $compoundType->isAcceptedBy($otherType, $strictTypes);
    }
}
