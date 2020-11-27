<?php

namespace _PhpScoperbd5d0c5f7638\SwitchTypeElimination;

class Foo
{
    /**
     * @param string|int $stringOrInt
     */
    public function doFoo($stringOrInt)
    {
        switch (\true) {
            case \is_int($stringOrInt):
                break;
            case doFoo():
                die;
        }
    }
}
