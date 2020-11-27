<?php

namespace _PhpScoperbd5d0c5f7638;

interface Serializable
{
    /** @return string */
    public function serialize();
    /** @return void */
    public function unserialize(string $data);
}
\class_alias('_PhpScoperbd5d0c5f7638\\Serializable', 'Serializable', \false);
