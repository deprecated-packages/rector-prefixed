<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\Signature;

interface CheckerInterface
{
    /**
     * @param string $phpCode
     *
     * @return bool
     */
    public function check(string $phpCode) : bool;
}
