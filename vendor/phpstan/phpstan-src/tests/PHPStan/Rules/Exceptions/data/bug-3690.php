<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Bug3690;

class HelloWorld
{
    public function sayHello() : bool
    {
        try {
            return eval('<?php

');
        } catch (\ParseError $e) {
            return \false;
        }
    }
}
