<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Roave\Signature;

interface CheckerInterface
{
    /**
     * @param string $phpCode
     *
     * @return bool
     */
    public function check(string $phpCode) : bool;
}
