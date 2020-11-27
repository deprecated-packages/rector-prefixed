<?php

namespace _PhpScoper88fe6e0ad041\AnonymousClassWrongFilename;

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
            public function doBar($test) : \_PhpScoper88fe6e0ad041\AnonymousClassWrongFilename\Bar
            {
                return new \_PhpScoper88fe6e0ad041\AnonymousClassWrongFilename\Bar();
            }
        };
        $bar = $foo->doBar($this);
        $bar->test();
    }
}
