<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\RenameGuard;

use _PhpScopere8e811afab72\Rector\Naming\Contract\Guard\ConflictingGuardInterface;
use _PhpScopere8e811afab72\Rector\Naming\Contract\RenameGuard\RenameGuardInterface;
use _PhpScopere8e811afab72\Rector\Naming\Contract\RenameValueObjectInterface;
final class PropertyRenameGuard implements \_PhpScopere8e811afab72\Rector\Naming\Contract\RenameGuard\RenameGuardInterface
{
    /**
     * @param ConflictingGuardInterface[] $guards
     */
    public function shouldSkip(\_PhpScopere8e811afab72\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject, array $guards) : bool
    {
        foreach ($guards as $guard) {
            if ($guard->check($renameValueObject)) {
                return \true;
            }
        }
        return \false;
    }
}
