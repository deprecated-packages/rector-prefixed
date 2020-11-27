<?php

namespace _PhpScopera143bcca66cb\SwitchInstanceOfFallthrough;

class Foo
{
    /**
     * @param object $object
     */
    public function doFoo($object)
    {
        switch (\true) {
            case $object instanceof \_PhpScopera143bcca66cb\SwitchInstanceOfFallthrough\A:
            case $object instanceof \_PhpScopera143bcca66cb\SwitchInstanceOfFallthrough\B:
                die;
        }
    }
}
