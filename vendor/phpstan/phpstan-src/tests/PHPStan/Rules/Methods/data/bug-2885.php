<?php

namespace _PhpScoperbd5d0c5f7638\Bug2885;

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
