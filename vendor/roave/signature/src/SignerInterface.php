<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Roave\Signature;

interface SignerInterface
{
    public function sign(string $phpCode) : string;
}
