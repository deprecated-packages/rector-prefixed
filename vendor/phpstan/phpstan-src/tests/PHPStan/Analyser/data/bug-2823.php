<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Bug2823;

class Foo
{
    public function sayHello() : void
    {
        \var_dump(new \LevelDB("./somedir"));
    }
}
