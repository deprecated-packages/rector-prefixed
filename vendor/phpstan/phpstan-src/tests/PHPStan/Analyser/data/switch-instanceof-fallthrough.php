<?php

namespace _PhpScoperabd03f0baf05\SwitchInstanceOfFallthrough;

class Foo
{
    /**
     * @param object $object
     */
    public function doFoo($object)
    {
        switch (\true) {
            case $object instanceof \_PhpScoperabd03f0baf05\SwitchInstanceOfFallthrough\A:
            case $object instanceof \_PhpScoperabd03f0baf05\SwitchInstanceOfFallthrough\B:
                die;
        }
    }
}
