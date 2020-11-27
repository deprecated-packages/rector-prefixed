<?php

namespace _PhpScoper26e51eeacccf\AnonymousClassWrongFilename;

class Foo
{
    public function doFoo() : void
    {
        $foo = new class
        {
            /**
             * @param self $test
             * @return Bar
             */
            public function doBar($test) : \_PhpScoper26e51eeacccf\AnonymousClassWrongFilename\Bar
            {
                return new \_PhpScoper26e51eeacccf\AnonymousClassWrongFilename\Bar();
            }
        };
        $bar = $foo->doBar($this);
        $bar->test();
    }
}
