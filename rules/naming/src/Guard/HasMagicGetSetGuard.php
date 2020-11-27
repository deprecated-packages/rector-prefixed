<?php

declare (strict_types=1);
namespace Rector\Naming\Guard;

use Rector\Naming\Contract\Guard\GuardInterface;
use Rector\Naming\Contract\RenameValueObjectInterface;
use Rector\Naming\ValueObject\PropertyRename;
final class HasMagicGetSetGuard implements \Rector\Naming\Contract\Guard\GuardInterface
{
    /**
     * @param PropertyRename $renameValueObject
     */
    public function check(\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : bool
    {
        return \method_exists($renameValueObject->getClassLikeName(), '__set') || \method_exists($renameValueObject->getClassLikeName(), '__get');
    }
}
