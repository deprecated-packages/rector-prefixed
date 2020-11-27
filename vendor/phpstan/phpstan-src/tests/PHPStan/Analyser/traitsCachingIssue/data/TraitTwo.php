<?php

namespace _PhpScoperbd5d0c5f7638\TraitsCachingIssue;

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
