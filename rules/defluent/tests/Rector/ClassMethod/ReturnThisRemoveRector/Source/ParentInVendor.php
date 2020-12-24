<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Defluent\Tests\Rector\ClassMethod\ReturnThisRemoveRector\Source;

use _PhpScoper0a6b37af0871\Rector\Defluent\Tests\Rector\ClassMethod\ReturnThisRemoveRector\Fixture\SkipParentInVendor;
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
