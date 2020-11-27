<?php

namespace _PhpScoper006a73f0e455;

interface OuterIterator extends \Iterator
{
    /** @return Iterator */
    public function getInnerIterator();
}
\class_alias('_PhpScoper006a73f0e455\\OuterIterator', 'OuterIterator', \false);
