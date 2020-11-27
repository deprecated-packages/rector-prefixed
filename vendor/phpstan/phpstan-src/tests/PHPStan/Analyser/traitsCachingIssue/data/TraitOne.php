<?php

namespace _PhpScopera143bcca66cb\TraitsCachingIssue;

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
