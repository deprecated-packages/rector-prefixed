<?php

namespace _PhpScoper006a73f0e455;

interface Iterator extends \Traversable
{
    /** @return mixed */
    public function current();
    /** @return void */
    public function next();
    /** @return mixed */
    public function key();
    /** @return bool */
    public function valid();
    /** @return void */
    public function rewind();
}
\class_alias('_PhpScoper006a73f0e455\\Iterator', 'Iterator', \false);
