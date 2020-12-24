<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming\Guard;

use _PhpScoper0a6b37af0871\Rector\Naming\Contract\Guard\ConflictingGuardInterface;
use _PhpScoper0a6b37af0871\Rector\Naming\Contract\RenameValueObjectInterface;
use _PhpScoper0a6b37af0871\Rector\Naming\ValueObject\PropertyRename;
final class NotPrivatePropertyGuard implements \_PhpScoper0a6b37af0871\Rector\Naming\Contract\Guard\ConflictingGuardInterface
{
    /**
     * @param PropertyRename $renameValueObject
     */
    public function check(\_PhpScoper0a6b37af0871\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : bool
    {
        return !$renameValueObject->isPrivateProperty();
    }
}
