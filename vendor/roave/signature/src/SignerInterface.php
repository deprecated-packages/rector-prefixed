<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\Roave\Signature;

interface SignerInterface
{
    public function sign(string $phpCode) : string;
}
