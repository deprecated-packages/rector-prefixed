<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Naming\RenameGuard;

use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Contract\Guard\ConflictingGuardInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Contract\RenameGuard\RenameGuardInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Contract\RenameValueObjectInterface;
final class PropertyRenameGuard implements \_PhpScoper2a4e7ab1ecbc\Rector\Naming\Contract\RenameGuard\RenameGuardInterface
{
    /**
     * @param ConflictingGuardInterface[] $guards
     */
    public function shouldSkip(\_PhpScoper2a4e7ab1ecbc\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject, array $guards) : bool
    {
        foreach ($guards as $guard) {
            if ($guard->check($renameValueObject)) {
                return \true;
            }
        }
        return \false;
    }
}
