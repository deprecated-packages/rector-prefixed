<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Naming\Contract;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
interface RenamerInterface
{
    public function rename(\_PhpScoper0a2ac50786fa\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node;
}
