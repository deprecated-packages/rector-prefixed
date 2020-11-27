<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\Bug2823;

class Foo
{
    public function sayHello() : void
    {
        \var_dump(new \LevelDB("./somedir"));
    }
}
