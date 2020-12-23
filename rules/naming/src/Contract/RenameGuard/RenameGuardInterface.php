<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Naming\Contract\RenameGuard;

use _PhpScoper0a2ac50786fa\Rector\Naming\Contract\Guard\ConflictingGuardInterface;
use _PhpScoper0a2ac50786fa\Rector\Naming\Contract\RenameValueObjectInterface;
interface RenameGuardInterface
{
    /**
     * @param ConflictingGuardInterface[] $guards
     */
    public function shouldSkip(\_PhpScoper0a2ac50786fa\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject, array $guards) : bool;
}
