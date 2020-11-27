<?php

namespace _PhpScoper88fe6e0ad041;

interface Serializable
{
    /** @return string */
    public function serialize();
    /** @return void */
    public function unserialize(string $data);
}
\class_alias('_PhpScoper88fe6e0ad041\\Serializable', 'Serializable', \false);
