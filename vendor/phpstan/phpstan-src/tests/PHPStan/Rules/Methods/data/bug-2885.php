<?php

namespace _PhpScoper88fe6e0ad041\Bug2885;

class Test
{
    /**
     * @return static
     */
    function do()
    {
        return $this->do()->do();
    }
}
