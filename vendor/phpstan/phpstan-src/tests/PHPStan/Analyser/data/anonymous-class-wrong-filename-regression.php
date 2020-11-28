<?php

namespace _PhpScoperabd03f0baf05\AnonymousClassWrongFilename;

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
            public function doBar($test) : \_PhpScoperabd03f0baf05\AnonymousClassWrongFilename\Bar
            {
                return new \_PhpScoperabd03f0baf05\AnonymousClassWrongFilename\Bar();
            }
        };
        $bar = $foo->doBar($this);
        $bar->test();
    }
}
