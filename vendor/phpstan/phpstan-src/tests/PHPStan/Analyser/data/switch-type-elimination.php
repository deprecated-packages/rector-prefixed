<?php

namespace _PhpScoper006a73f0e455\SwitchTypeElimination;

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
