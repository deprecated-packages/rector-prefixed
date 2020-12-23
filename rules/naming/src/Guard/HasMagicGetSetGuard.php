<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Naming\Guard;

use _PhpScoper0a2ac50786fa\Rector\Naming\Contract\Guard\ConflictingGuardInterface;
use _PhpScoper0a2ac50786fa\Rector\Naming\Contract\RenameValueObjectInterface;
use _PhpScoper0a2ac50786fa\Rector\Naming\ValueObject\PropertyRename;
final class HasMagicGetSetGuard implements \_PhpScoper0a2ac50786fa\Rector\Naming\Contract\Guard\ConflictingGuardInterface
{
    /**
     * @param PropertyRename $renameValueObject
     */
    public function check(\_PhpScoper0a2ac50786fa\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : bool
    {
        return \method_exists($renameValueObject->getClassLikeName(), '__set') || \method_exists($renameValueObject->getClassLikeName(), '__get');
    }
}
