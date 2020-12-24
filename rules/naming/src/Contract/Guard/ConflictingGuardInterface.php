<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming\Contract\Guard;

use _PhpScoper0a6b37af0871\Rector\Naming\Contract\RenameValueObjectInterface;
interface ConflictingGuardInterface
{
    public function check(\_PhpScoper0a6b37af0871\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : bool;
}
