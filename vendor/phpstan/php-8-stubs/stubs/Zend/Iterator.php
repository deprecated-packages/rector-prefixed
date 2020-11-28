<?php

namespace _PhpScoperabd03f0baf05;

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
\class_alias('_PhpScoperabd03f0baf05\\Iterator', 'Iterator', \false);
