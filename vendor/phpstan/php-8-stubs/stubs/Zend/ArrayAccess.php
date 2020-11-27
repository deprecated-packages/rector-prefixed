<?php

namespace _PhpScoper26e51eeacccf;

interface ArrayAccess
{
    /** @return bool */
    public function offsetExists(mixed $offset);
    /**
     * Actually this should be return by ref but atm cannot be.
     * @return mixed
     */
    public function offsetGet(mixed $offset);
    /** @return void */
    public function offsetSet(mixed $offset, mixed $value);
    /** @return void */
    public function offsetUnset(mixed $offset);
}
\class_alias('_PhpScoper26e51eeacccf\\ArrayAccess', 'ArrayAccess', \false);
