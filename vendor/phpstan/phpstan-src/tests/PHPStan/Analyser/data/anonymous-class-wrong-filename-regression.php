<?php

namespace _PhpScoper006a73f0e455\AnonymousClassWrongFilename;

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
            public function doBar($test) : \_PhpScoper006a73f0e455\AnonymousClassWrongFilename\Bar
            {
                return new \_PhpScoper006a73f0e455\AnonymousClassWrongFilename\Bar();
            }
        };
        $bar = $foo->doBar($this);
        $bar->test();
    }
}
