<?php

declare (strict_types=1);
namespace Rector\Naming\Contract\Guard;

use Rector\Naming\Contract\RenameValueObjectInterface;
interface GuardInterface
{
    public function check(\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : bool;
}
