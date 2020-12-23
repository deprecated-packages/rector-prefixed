<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Naming\RenameGuard;

use _PhpScoper0a2ac50786fa\Rector\Naming\Contract\Guard\ConflictingGuardInterface;
use _PhpScoper0a2ac50786fa\Rector\Naming\Contract\RenameGuard\RenameGuardInterface;
use _PhpScoper0a2ac50786fa\Rector\Naming\Contract\RenameValueObjectInterface;
final class PropertyRenameGuard implements \_PhpScoper0a2ac50786fa\Rector\Naming\Contract\RenameGuard\RenameGuardInterface
{
    /**
     * @param ConflictingGuardInterface[] $guards
     */
    public function shouldSkip(\_PhpScoper0a2ac50786fa\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject, array $guards) : bool
    {
        foreach ($guards as $guard) {
            if ($guard->check($renameValueObject)) {
                return \true;
            }
        }
        return \false;
    }
}
