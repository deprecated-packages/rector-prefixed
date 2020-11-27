<?php

namespace _PhpScopera143bcca66cb\AnonymousClassWrongFilename;

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
            public function doBar($test) : \_PhpScopera143bcca66cb\AnonymousClassWrongFilename\Bar
            {
                return new \_PhpScopera143bcca66cb\AnonymousClassWrongFilename\Bar();
            }
        };
        $bar = $foo->doBar($this);
        $bar->test();
    }
}
