<?php

namespace _PhpScopera143bcca66cb;

interface Serializable
{
    /** @return string */
    public function serialize();
    /** @return void */
    public function unserialize(string $data);
}
\class_alias('_PhpScopera143bcca66cb\\Serializable', 'Serializable', \false);
