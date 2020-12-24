<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Naming\Contract\RenameGuard;

use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Contract\Guard\ConflictingGuardInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Contract\RenameValueObjectInterface;
interface RenameGuardInterface
{
    /**
     * @param ConflictingGuardInterface[] $guards
     */
    public function shouldSkip(\_PhpScoper2a4e7ab1ecbc\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject, array $guards) : bool;
}
