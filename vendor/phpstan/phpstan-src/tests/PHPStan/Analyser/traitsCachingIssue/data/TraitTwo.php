<?php

namespace _PhpScoper26e51eeacccf\TraitsCachingIssue;

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
