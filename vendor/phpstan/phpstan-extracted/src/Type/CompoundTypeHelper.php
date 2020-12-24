<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type;

use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
class CompoundTypeHelper
{
    public static function accepts(\_PhpScoperb75b35f52b74\PHPStan\Type\CompoundType $compoundType, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $otherType, bool $strictTypes) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $compoundType->isAcceptedBy($otherType, $strictTypes);
    }
}
