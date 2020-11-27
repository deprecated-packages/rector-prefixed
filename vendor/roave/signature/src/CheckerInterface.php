<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Roave\Signature;

interface CheckerInterface
{
    /**
     * @param string $phpCode
     *
     * @return bool
     */
    public function check(string $phpCode) : bool;
}
