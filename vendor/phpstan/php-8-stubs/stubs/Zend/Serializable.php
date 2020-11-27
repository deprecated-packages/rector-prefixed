<?php

namespace _PhpScoper006a73f0e455;

interface Serializable
{
    /** @return string */
    public function serialize();
    /** @return void */
    public function unserialize(string $data);
}
\class_alias('_PhpScoper006a73f0e455\\Serializable', 'Serializable', \false);
