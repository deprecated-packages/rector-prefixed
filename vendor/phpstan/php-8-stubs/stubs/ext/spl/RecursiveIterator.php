<?php

namespace _PhpScoperabd03f0baf05;

interface RecursiveIterator extends \Iterator
{
    /** @return bool */
    public function hasChildren();
    /** @return RecursiveIterator */
    public function getChildren();
}
\class_alias('_PhpScoperabd03f0baf05\\RecursiveIterator', 'RecursiveIterator', \false);
