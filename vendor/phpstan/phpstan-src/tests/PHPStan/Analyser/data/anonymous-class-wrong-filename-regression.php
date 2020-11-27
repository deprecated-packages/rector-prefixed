<?php

namespace _PhpScoperbd5d0c5f7638\AnonymousClassWrongFilename;

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
            public function doBar($test) : \_PhpScoperbd5d0c5f7638\AnonymousClassWrongFilename\Bar
            {
                return new \_PhpScoperbd5d0c5f7638\AnonymousClassWrongFilename\Bar();
            }
        };
        $bar = $foo->doBar($this);
        $bar->test();
    }
}
