<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Bug2823;

class Foo
{
    public function sayHello() : void
    {
        \var_dump(new \LevelDB("./somedir"));
    }
}
