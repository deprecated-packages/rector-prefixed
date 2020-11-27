<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\Roave\Signature;

interface CheckerInterface
{
    /**
     * @param string $phpCode
     *
     * @return bool
     */
    public function check(string $phpCode) : bool;
}
