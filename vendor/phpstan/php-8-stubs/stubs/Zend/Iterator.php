<?php

namespace _PhpScopera143bcca66cb;

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
\class_alias('_PhpScopera143bcca66cb\\Iterator', 'Iterator', \false);
