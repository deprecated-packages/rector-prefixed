<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\Roave\Signature\Encoder;

interface EncoderInterface
{
    public function encode(string $codeWithoutSignature) : string;
    public function verify(string $codeWithoutSignature, string $signature) : bool;
}
