<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\Contract\Guard;

use _PhpScoperb75b35f52b74\Rector\Naming\Contract\RenameValueObjectInterface;
interface ConflictingGuardInterface
{
    public function check(\_PhpScoperb75b35f52b74\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : bool;
}
