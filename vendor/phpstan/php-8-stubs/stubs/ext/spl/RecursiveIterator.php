<?php

namespace _PhpScopera143bcca66cb;

interface RecursiveIterator extends \Iterator
{
    /** @return bool */
    public function hasChildren();
    /** @return RecursiveIterator */
    public function getChildren();
}
\class_alias('_PhpScopera143bcca66cb\\RecursiveIterator', 'RecursiveIterator', \false);
