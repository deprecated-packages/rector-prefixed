<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DowngradePhp74\Contract\Rector;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
interface DowngradeTypedPropertyRectorInterface
{
    public function shouldRemoveProperty(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : bool;
}
