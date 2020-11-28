<?php

namespace _PhpScoperabd03f0baf05;

interface OuterIterator extends \Iterator
{
    /** @return Iterator */
    public function getInnerIterator();
}
\class_alias('_PhpScoperabd03f0baf05\\OuterIterator', 'OuterIterator', \false);
