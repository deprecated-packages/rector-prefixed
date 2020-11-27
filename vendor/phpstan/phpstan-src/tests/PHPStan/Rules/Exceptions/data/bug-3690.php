<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Bug3690;

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
