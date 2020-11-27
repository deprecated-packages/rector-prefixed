<?php

namespace _PhpScoper26e51eeacccf;

interface IteratorAggregate extends \Traversable
{
    /** @return Traversable */
    public function getIterator();
}
\class_alias('_PhpScoper26e51eeacccf\\IteratorAggregate', 'IteratorAggregate', \false);
