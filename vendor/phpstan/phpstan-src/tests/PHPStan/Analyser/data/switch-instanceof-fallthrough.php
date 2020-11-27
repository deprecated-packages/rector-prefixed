<?php

namespace _PhpScoper26e51eeacccf\SwitchInstanceOfFallthrough;

class Foo
{
    /**
     * @param object $object
     */
    public function doFoo($object)
    {
        switch (\true) {
            case $object instanceof \_PhpScoper26e51eeacccf\SwitchInstanceOfFallthrough\A:
            case $object instanceof \_PhpScoper26e51eeacccf\SwitchInstanceOfFallthrough\B:
                die;
        }
    }
}
