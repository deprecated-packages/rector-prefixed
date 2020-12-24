<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\RenameGuard;

use _PhpScoperb75b35f52b74\Rector\Naming\Contract\Guard\ConflictingGuardInterface;
use _PhpScoperb75b35f52b74\Rector\Naming\Contract\RenameGuard\RenameGuardInterface;
use _PhpScoperb75b35f52b74\Rector\Naming\Contract\RenameValueObjectInterface;
final class PropertyRenameGuard implements \_PhpScoperb75b35f52b74\Rector\Naming\Contract\RenameGuard\RenameGuardInterface
{
    /**
     * @param ConflictingGuardInterface[] $guards
     */
    public function shouldSkip(\_PhpScoperb75b35f52b74\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject, array $guards) : bool
    {
        foreach ($guards as $guard) {
            if ($guard->check($renameValueObject)) {
                return \true;
            }
        }
        return \false;
    }
}
