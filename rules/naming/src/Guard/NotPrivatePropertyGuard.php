<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Naming\Guard;

use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Contract\Guard\ConflictingGuardInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Contract\RenameValueObjectInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\ValueObject\PropertyRename;
final class NotPrivatePropertyGuard implements \_PhpScoper2a4e7ab1ecbc\Rector\Naming\Contract\Guard\ConflictingGuardInterface
{
    /**
     * @param PropertyRename $renameValueObject
     */
    public function check(\_PhpScoper2a4e7ab1ecbc\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : bool
    {
        return !$renameValueObject->isPrivateProperty();
    }
}
