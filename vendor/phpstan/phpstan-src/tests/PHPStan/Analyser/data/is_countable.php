<?php

namespace _PhpScoper006a73f0e455\IsCountable;

class Foo
{
    /**
     * @param array|\Countable|string $union
     */
    public function doFoo($union)
    {
        if (\is_countable($union)) {
            'is';
        } else {
            'is_not';
        }
    }
}
