<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\Roave\Signature\Encoder;

final class Sha1SumEncoder implements \_PhpScoper26e51eeacccf\Roave\Signature\Encoder\EncoderInterface
{
    /**
     * {@inheritDoc}
     */
    public function encode(string $codeWithoutSignature) : string
    {
        return \sha1($codeWithoutSignature);
    }
    /**
     * {@inheritDoc}
     */
    public function verify(string $codeWithoutSignature, string $signature) : bool
    {
        return \hash_equals($this->encode($codeWithoutSignature), $signature);
    }
}
