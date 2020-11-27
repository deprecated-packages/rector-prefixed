<?php

namespace _PhpScoper006a73f0e455;

interface RecursiveIterator extends \Iterator
{
    /** @return bool */
    public function hasChildren();
    /** @return RecursiveIterator */
    public function getChildren();
}
\class_alias('_PhpScoper006a73f0e455\\RecursiveIterator', 'RecursiveIterator', \false);
