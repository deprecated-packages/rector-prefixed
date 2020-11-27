<?php

namespace _PhpScoper006a73f0e455\ClassExistsAutoloadingError;

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
