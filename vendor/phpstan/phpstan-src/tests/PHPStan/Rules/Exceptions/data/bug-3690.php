<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Bug3690;

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
