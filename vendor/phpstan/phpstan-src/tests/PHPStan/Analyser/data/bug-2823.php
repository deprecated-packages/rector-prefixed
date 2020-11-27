<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Bug2823;

class Foo
{
    public function sayHello() : void
    {
        \var_dump(new \LevelDB("./somedir"));
    }
}
