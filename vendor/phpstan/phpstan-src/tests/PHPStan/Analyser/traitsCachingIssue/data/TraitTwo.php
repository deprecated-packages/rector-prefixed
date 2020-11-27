<?php

namespace _PhpScopera143bcca66cb\TraitsCachingIssue;

use stdClass as Foo;
trait TraitTwo
{
    /**
     * @return Foo
     */
    public function doFoo()
    {
        return new \stdClass();
    }
}
