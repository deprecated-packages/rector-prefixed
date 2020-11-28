<?php

namespace _PhpScoperabd03f0baf05\ClassExistsAutoloadingError;

class Foo
{
    public function doFoo() : void
    {
        $className = '\\PHPStan\\GitHubIssue2359';
        if (\class_exists($className)) {
            \var_dump(new $className());
        }
    }
}
