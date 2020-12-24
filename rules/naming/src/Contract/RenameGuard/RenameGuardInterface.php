<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\Contract\RenameGuard;

use _PhpScoperb75b35f52b74\Rector\Naming\Contract\Guard\ConflictingGuardInterface;
use _PhpScoperb75b35f52b74\Rector\Naming\Contract\RenameValueObjectInterface;
interface RenameGuardInterface
{
    /**
     * @param ConflictingGuardInterface[] $guards
     */
    public function shouldSkip(\_PhpScoperb75b35f52b74\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject, array $guards) : bool;
}
