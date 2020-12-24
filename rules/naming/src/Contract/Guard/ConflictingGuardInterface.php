<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\Contract\Guard;

use _PhpScopere8e811afab72\Rector\Naming\Contract\RenameValueObjectInterface;
interface ConflictingGuardInterface
{
    public function check(\_PhpScopere8e811afab72\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : bool;
}
