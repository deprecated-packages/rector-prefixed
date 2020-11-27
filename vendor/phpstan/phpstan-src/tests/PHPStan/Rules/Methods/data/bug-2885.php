<?php

namespace _PhpScoper26e51eeacccf\Bug2885;

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
