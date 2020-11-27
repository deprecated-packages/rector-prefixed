<?php

namespace _PhpScoper88fe6e0ad041\Bug2875MissingReturn;

class A
{
}
class B
{
}
class HelloWorld
{
    /** @param A|B|null $obj */
    function one($obj) : int
    {
        if ($obj === null) {
            return 1;
        } else {
            if ($obj instanceof \_PhpScoper88fe6e0ad041\Bug2875MissingReturn\A) {
                return 2;
            } else {
                if ($obj instanceof \_PhpScoper88fe6e0ad041\Bug2875MissingReturn\B) {
                    return 3;
                }
            }
        }
    }
}
