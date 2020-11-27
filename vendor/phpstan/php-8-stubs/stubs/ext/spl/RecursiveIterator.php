<?php

namespace _PhpScoperbd5d0c5f7638;

interface RecursiveIterator extends \Iterator
{
    /** @return bool */
    public function hasChildren();
    /** @return RecursiveIterator */
    public function getChildren();
}
\class_alias('_PhpScoperbd5d0c5f7638\\RecursiveIterator', 'RecursiveIterator', \false);
