<?php

namespace _PhpScopera143bcca66cb\Bug2885;

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
