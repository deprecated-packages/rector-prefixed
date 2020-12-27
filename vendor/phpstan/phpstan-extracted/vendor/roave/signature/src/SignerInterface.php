<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f__UniqueRector\Roave\Signature;

interface SignerInterface
{
    public function sign(string $phpCode) : string;
}
