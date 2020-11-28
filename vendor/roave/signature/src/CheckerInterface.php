<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Roave\Signature;

interface CheckerInterface
{
    /**
     * @param string $phpCode
     *
     * @return bool
     */
    public function check(string $phpCode) : bool;
}
