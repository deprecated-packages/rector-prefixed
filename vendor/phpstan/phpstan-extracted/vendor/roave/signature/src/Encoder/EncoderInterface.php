<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\Signature\Encoder;

interface EncoderInterface
{
    public function encode(string $codeWithoutSignature) : string;
    public function verify(string $codeWithoutSignature, string $signature) : bool;
}
