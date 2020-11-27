<?php

namespace _PhpScopera143bcca66cb;

interface OuterIterator extends \Iterator
{
    /** @return Iterator */
    public function getInnerIterator();
}
\class_alias('_PhpScopera143bcca66cb\\OuterIterator', 'OuterIterator', \false);
