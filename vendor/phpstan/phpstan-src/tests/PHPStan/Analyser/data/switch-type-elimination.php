<?php

namespace _PhpScoper88fe6e0ad041\SwitchTypeElimination;

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
