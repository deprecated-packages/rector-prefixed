<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Roave\Signature;

interface SignerInterface
{
    public function sign(string $phpCode) : string;
}
