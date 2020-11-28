<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Roave\Signature;

interface SignerInterface
{
    public function sign(string $phpCode) : string;
}
