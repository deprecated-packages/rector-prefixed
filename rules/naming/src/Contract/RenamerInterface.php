<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\Contract;

use _PhpScopere8e811afab72\PhpParser\Node;
interface RenamerInterface
{
    public function rename(\_PhpScopere8e811afab72\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : ?\_PhpScopere8e811afab72\PhpParser\Node;
}
