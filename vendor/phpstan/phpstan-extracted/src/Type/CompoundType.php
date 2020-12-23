<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type;

use _PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
interface CompoundType extends \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
{
    public function isSubTypeOf(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $otherType) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
    public function isAcceptedBy(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
    public function isGreaterThan(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $otherType, bool $orEqual = \false) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
}
