<?php

namespace _PhpScoper006a73f0e455\SwitchInstanceOfFallthrough;

class Foo
{
    /**
     * @param object $object
     */
    public function doFoo($object)
    {
        switch (\true) {
            case $object instanceof \_PhpScoper006a73f0e455\SwitchInstanceOfFallthrough\A:
            case $object instanceof \_PhpScoper006a73f0e455\SwitchInstanceOfFallthrough\B:
                die;
        }
    }
}
