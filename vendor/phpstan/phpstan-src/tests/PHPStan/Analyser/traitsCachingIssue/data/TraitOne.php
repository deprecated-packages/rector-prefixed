<?php

namespace _PhpScoper006a73f0e455\TraitsCachingIssue;

use stdClass as Foo;
trait TraitOne
{
    /**
     * @return Foo
     */
    public function doFoo()
    {
        return new \stdClass();
    }
}
