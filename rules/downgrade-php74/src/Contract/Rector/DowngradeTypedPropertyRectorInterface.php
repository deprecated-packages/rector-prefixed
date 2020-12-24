<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DowngradePhp74\Contract\Rector;

use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
interface DowngradeTypedPropertyRectorInterface
{
    public function shouldRemoveProperty(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property) : bool;
}
