<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Defluent\Tests\Rector\ClassMethod\ReturnThisRemoveRector\Source;

use _PhpScopere8e811afab72\Rector\Defluent\Tests\Rector\ClassMethod\ReturnThisRemoveRector\Fixture\SkipParentInVendor;
class ParentInVendor
{
    /**
     * @return SkipParentInVendor
     */
    public function someFunction()
    {
        foo();
        return $this;
    }
}
