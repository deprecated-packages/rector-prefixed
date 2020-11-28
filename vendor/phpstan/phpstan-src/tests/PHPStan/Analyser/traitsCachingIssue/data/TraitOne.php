<?php

namespace _PhpScoperabd03f0baf05\TraitsCachingIssue;

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
