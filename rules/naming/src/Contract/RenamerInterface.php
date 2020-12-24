<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming\Contract;

use _PhpScoper0a6b37af0871\PhpParser\Node;
interface RenamerInterface
{
    public function rename(\_PhpScoper0a6b37af0871\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : ?\_PhpScoper0a6b37af0871\PhpParser\Node;
}
