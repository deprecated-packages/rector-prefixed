<?php

namespace _PhpScoperabd03f0baf05\Bug2885;

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
