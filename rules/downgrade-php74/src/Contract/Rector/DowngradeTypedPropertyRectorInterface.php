<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\DowngradePhp74\Contract\Rector;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property;
interface DowngradeTypedPropertyRectorInterface
{
    public function shouldRemoveProperty(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property $property) : bool;
}
