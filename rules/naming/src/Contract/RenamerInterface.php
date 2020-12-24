<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\Contract;

use _PhpScoperb75b35f52b74\PhpParser\Node;
interface RenamerInterface
{
    public function rename(\_PhpScoperb75b35f52b74\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : ?\_PhpScoperb75b35f52b74\PhpParser\Node;
}
