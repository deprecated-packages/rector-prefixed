<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Roave\Signature\Encoder;

final class Sha1SumEncoder implements \_PhpScoper88fe6e0ad041\Roave\Signature\Encoder\EncoderInterface
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
