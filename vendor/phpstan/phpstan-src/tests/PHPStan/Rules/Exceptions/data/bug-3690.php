<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Bug3690;

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
