<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming\RenameGuard;

use _PhpScoper0a6b37af0871\Rector\Naming\Contract\Guard\ConflictingGuardInterface;
use _PhpScoper0a6b37af0871\Rector\Naming\Contract\RenameGuard\RenameGuardInterface;
use _PhpScoper0a6b37af0871\Rector\Naming\Contract\RenameValueObjectInterface;
final class PropertyRenameGuard implements \_PhpScoper0a6b37af0871\Rector\Naming\Contract\RenameGuard\RenameGuardInterface
{
    /**
     * @param ConflictingGuardInterface[] $guards
     */
    public function shouldSkip(\_PhpScoper0a6b37af0871\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject, array $guards) : bool
    {
        foreach ($guards as $guard) {
            if ($guard->check($renameValueObject)) {
                return \true;
            }
        }
        return \false;
    }
}
