<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\Guard;

use _PhpScoperb75b35f52b74\Rector\Naming\Contract\Guard\ConflictingGuardInterface;
use _PhpScoperb75b35f52b74\Rector\Naming\Contract\RenameValueObjectInterface;
use _PhpScoperb75b35f52b74\Rector\Naming\ValueObject\PropertyRename;
final class NotPrivatePropertyGuard implements \_PhpScoperb75b35f52b74\Rector\Naming\Contract\Guard\ConflictingGuardInterface
{
    /**
     * @param PropertyRename $renameValueObject
     */
    public function check(\_PhpScoperb75b35f52b74\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : bool
    {
        return !$renameValueObject->isPrivateProperty();
    }
}
