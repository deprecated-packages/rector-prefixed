<?php

declare (strict_types=1);
namespace Rector\Naming\RenameGuard;

use Rector\Naming\Contract\Guard\GuardInterface;
use Rector\Naming\Contract\RenameGuard\RenameGuardInterface;
use Rector\Naming\Contract\RenameValueObjectInterface;
final class PropertyRenameGuard implements \Rector\Naming\Contract\RenameGuard\RenameGuardInterface
{
    /**
     * @param GuardInterface[] $guards
     */
    public function shouldSkip(\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject, array $guards) : bool
    {
        foreach ($guards as $guard) {
            if ($guard->check($renameValueObject)) {
                return \true;
            }
        }
        return \false;
    }
}
