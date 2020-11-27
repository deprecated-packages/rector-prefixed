<?php

namespace _PhpScoperbd5d0c5f7638\ClassExistsAutoloadingError;

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
