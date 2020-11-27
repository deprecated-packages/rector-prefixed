<?php

namespace _PhpScoper88fe6e0ad041\TraitsCachingIssue;

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
