<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\Contract\RenameGuard;

use _PhpScopere8e811afab72\Rector\Naming\Contract\Guard\ConflictingGuardInterface;
use _PhpScopere8e811afab72\Rector\Naming\Contract\RenameValueObjectInterface;
interface RenameGuardInterface
{
    /**
     * @param ConflictingGuardInterface[] $guards
     */
    public function shouldSkip(\_PhpScopere8e811afab72\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject, array $guards) : bool;
}
