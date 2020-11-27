<?php

namespace _PhpScoperbd5d0c5f7638\IsCountable;

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
