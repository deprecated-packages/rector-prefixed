<?php

namespace _PhpScoper26e51eeacccf\ClassExistsAutoloadingError;

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
