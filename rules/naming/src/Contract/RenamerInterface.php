<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Naming\Contract;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
interface RenamerInterface
{
    public function rename(\_PhpScoper2a4e7ab1ecbc\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node;
}
