<?php

namespace _PhpScoper26e51eeacccf;

interface Serializable
{
    /** @return string */
    public function serialize();
    /** @return void */
    public function unserialize(string $data);
}
\class_alias('_PhpScoper26e51eeacccf\\Serializable', 'Serializable', \false);
