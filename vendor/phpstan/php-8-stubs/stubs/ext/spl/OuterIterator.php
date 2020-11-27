<?php

namespace _PhpScoper88fe6e0ad041;

interface OuterIterator extends \Iterator
{
    /** @return Iterator */
    public function getInnerIterator();
}
\class_alias('_PhpScoper88fe6e0ad041\\OuterIterator', 'OuterIterator', \false);
