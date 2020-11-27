<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Roave\Signature;

interface CheckerInterface
{
    /**
     * @param string $phpCode
     *
     * @return bool
     */
    public function check(string $phpCode) : bool;
}
