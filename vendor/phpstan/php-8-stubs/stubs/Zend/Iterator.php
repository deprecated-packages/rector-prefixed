<?php

namespace _PhpScoper26e51eeacccf;

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
\class_alias('_PhpScoper26e51eeacccf\\Iterator', 'Iterator', \false);
