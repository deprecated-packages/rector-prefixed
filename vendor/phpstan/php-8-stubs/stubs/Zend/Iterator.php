<?php

namespace _PhpScoperbd5d0c5f7638;

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
\class_alias('_PhpScoperbd5d0c5f7638\\Iterator', 'Iterator', \false);
