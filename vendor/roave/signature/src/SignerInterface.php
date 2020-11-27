<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Roave\Signature;

interface SignerInterface
{
    public function sign(string $phpCode) : string;
}
