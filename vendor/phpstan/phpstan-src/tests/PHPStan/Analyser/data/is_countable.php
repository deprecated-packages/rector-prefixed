<?php

namespace _PhpScoper88fe6e0ad041\IsCountable;

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
