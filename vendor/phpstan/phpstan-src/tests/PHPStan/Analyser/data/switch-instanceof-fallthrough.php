<?php

namespace _PhpScoper88fe6e0ad041\SwitchInstanceOfFallthrough;

class Foo
{
    /**
     * @param object $object
     */
    public function doFoo($object)
    {
        switch (\true) {
            case $object instanceof \_PhpScoper88fe6e0ad041\SwitchInstanceOfFallthrough\A:
            case $object instanceof \_PhpScoper88fe6e0ad041\SwitchInstanceOfFallthrough\B:
                die;
        }
    }
}
