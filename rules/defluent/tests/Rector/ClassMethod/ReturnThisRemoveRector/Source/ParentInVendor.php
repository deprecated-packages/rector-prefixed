<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Defluent\Tests\Rector\ClassMethod\ReturnThisRemoveRector\Source;

use _PhpScoperb75b35f52b74\Rector\Defluent\Tests\Rector\ClassMethod\ReturnThisRemoveRector\Fixture\SkipParentInVendor;
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
