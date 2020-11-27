<?php

namespace _PhpScoper26e51eeacccf;

interface OuterIterator extends \Iterator
{
    /** @return Iterator */
    public function getInnerIterator();
}
\class_alias('_PhpScoper26e51eeacccf\\OuterIterator', 'OuterIterator', \false);
