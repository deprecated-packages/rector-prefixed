<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Roave\Signature;

interface CheckerInterface
{
    /**
     * @param string $phpCode
     *
     * @return bool
     */
    public function check(string $phpCode) : bool;
}
