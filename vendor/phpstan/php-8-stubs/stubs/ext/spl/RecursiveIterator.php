<?php

namespace _PhpScoper26e51eeacccf;

interface RecursiveIterator extends \Iterator
{
    /** @return bool */
    public function hasChildren();
    /** @return RecursiveIterator */
    public function getChildren();
}
\class_alias('_PhpScoper26e51eeacccf\\RecursiveIterator', 'RecursiveIterator', \false);
