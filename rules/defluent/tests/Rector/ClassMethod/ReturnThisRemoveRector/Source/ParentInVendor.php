<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Defluent\Tests\Rector\ClassMethod\ReturnThisRemoveRector\Source;

use _PhpScoper0a2ac50786fa\Rector\Defluent\Tests\Rector\ClassMethod\ReturnThisRemoveRector\Fixture\SkipParentInVendor;
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
