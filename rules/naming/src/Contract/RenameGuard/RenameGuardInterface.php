<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming\Contract\RenameGuard;

use _PhpScoper0a6b37af0871\Rector\Naming\Contract\Guard\ConflictingGuardInterface;
use _PhpScoper0a6b37af0871\Rector\Naming\Contract\RenameValueObjectInterface;
interface RenameGuardInterface
{
    /**
     * @param ConflictingGuardInterface[] $guards
     */
    public function shouldSkip(\_PhpScoper0a6b37af0871\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject, array $guards) : bool;
}
