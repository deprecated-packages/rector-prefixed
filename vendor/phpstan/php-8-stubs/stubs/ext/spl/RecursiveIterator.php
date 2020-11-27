<?php

namespace _PhpScoper88fe6e0ad041;

interface RecursiveIterator extends \Iterator
{
    /** @return bool */
    public function hasChildren();
    /** @return RecursiveIterator */
    public function getChildren();
}
\class_alias('_PhpScoper88fe6e0ad041\\RecursiveIterator', 'RecursiveIterator', \false);
