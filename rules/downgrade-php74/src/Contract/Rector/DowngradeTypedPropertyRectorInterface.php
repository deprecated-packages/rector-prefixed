<?php

declare (strict_types=1);
namespace Rector\DowngradePhp74\Contract\Rector;

use PhpParser\Node\Stmt\Property;
interface DowngradeTypedPropertyRectorInterface
{
    public function shouldRemoveProperty(\PhpParser\Node\Stmt\Property $property) : bool;
}
