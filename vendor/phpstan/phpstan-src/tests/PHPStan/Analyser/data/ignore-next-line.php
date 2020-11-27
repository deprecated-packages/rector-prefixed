<?php

namespace _PhpScoper88fe6e0ad041\IgnoreNextLine;

class Foo
{
    public function doFoo() : void
    {
        fail();
        // reported
        // @phpstan-ignore-next-line
        fail();
        /* @phpstan-ignore-next-line */
        fail();
        /** @phpstan-ignore-next-line */
        fail();
        /*
         * @phpstan-ignore-next-line
         */
        fail();
        /**
         * @phpstan-ignore-next-line
         */
        fail();
        fail();
        // reported
        // @phpstan-ignore-next-line
        if (fail()) {
            fail();
            // reported
        }
        /** @phpstan-ignore-next-line */
        succ();
        // reported as unmatched
    }
}
