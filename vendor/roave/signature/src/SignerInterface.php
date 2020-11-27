<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Roave\Signature;

interface SignerInterface
{
    public function sign(string $phpCode) : string;
}
