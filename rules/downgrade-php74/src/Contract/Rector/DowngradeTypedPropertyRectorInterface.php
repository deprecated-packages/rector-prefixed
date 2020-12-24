<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DowngradePhp74\Contract\Rector;

use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
interface DowngradeTypedPropertyRectorInterface
{
    public function shouldRemoveProperty(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property) : bool;
}
