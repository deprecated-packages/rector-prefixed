<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\Guard;

use _PhpScopere8e811afab72\Rector\Naming\Contract\Guard\ConflictingGuardInterface;
use _PhpScopere8e811afab72\Rector\Naming\Contract\RenameValueObjectInterface;
use _PhpScopere8e811afab72\Rector\Naming\ValueObject\PropertyRename;
final class NotPrivatePropertyGuard implements \_PhpScopere8e811afab72\Rector\Naming\Contract\Guard\ConflictingGuardInterface
{
    /**
     * @param PropertyRename $renameValueObject
     */
    public function check(\_PhpScopere8e811afab72\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : bool
    {
        return !$renameValueObject->isPrivateProperty();
    }
}
