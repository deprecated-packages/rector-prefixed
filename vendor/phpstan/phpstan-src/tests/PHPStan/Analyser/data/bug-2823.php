<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Bug2823;

class Foo
{
    public function sayHello() : void
    {
        \var_dump(new \LevelDB("./somedir"));
    }
}
