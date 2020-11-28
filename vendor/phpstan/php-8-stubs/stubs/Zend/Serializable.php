<?php

namespace _PhpScoperabd03f0baf05;

interface Serializable
{
    /** @return string */
    public function serialize();
    /** @return void */
    public function unserialize(string $data);
}
\class_alias('_PhpScoperabd03f0baf05\\Serializable', 'Serializable', \false);
