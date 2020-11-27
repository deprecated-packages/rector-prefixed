<?php

namespace _PhpScoperbd5d0c5f7638\SwitchInstanceOfFallthrough;

class Foo
{
    /**
     * @param object $object
     */
    public function doFoo($object)
    {
        switch (\true) {
            case $object instanceof \_PhpScoperbd5d0c5f7638\SwitchInstanceOfFallthrough\A:
            case $object instanceof \_PhpScoperbd5d0c5f7638\SwitchInstanceOfFallthrough\B:
                die;
        }
    }
}
