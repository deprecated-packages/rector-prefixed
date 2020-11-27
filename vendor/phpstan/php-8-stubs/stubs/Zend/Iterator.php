<?php

namespace _PhpScoper88fe6e0ad041;

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
\class_alias('_PhpScoper88fe6e0ad041\\Iterator', 'Iterator', \false);
