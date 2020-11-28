<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Bug2823;

class Foo
{
    public function sayHello() : void
    {
        \var_dump(new \LevelDB("./somedir"));
    }
}
