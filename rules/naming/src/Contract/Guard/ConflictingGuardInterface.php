<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Naming\Contract\Guard;

use _PhpScoper0a2ac50786fa\Rector\Naming\Contract\RenameValueObjectInterface;
interface ConflictingGuardInterface
{
    public function check(\_PhpScoper0a2ac50786fa\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : bool;
}
