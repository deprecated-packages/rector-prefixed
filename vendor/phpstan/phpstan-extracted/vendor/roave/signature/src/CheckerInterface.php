<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\Signature;

interface CheckerInterface
{
    /**
     * @param string $phpCode
     *
     * @return bool
     */
    public function check(string $phpCode) : bool;
}
