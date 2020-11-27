<?php

namespace _PhpScoperbd5d0c5f7638;

interface OuterIterator extends \Iterator
{
    /** @return Iterator */
    public function getInnerIterator();
}
\class_alias('_PhpScoperbd5d0c5f7638\\OuterIterator', 'OuterIterator', \false);
