<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\Signature\Encoder;

final class HmacEncoder implements \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\Signature\Encoder\EncoderInterface
{
    /**
     * @var string
     */
    private $hmacKey;
    public function __construct(string $hmacKey)
    {
        $this->hmacKey = $hmacKey;
    }
    /**
     * {@inheritDoc}
     */
    public function encode(string $codeWithoutSignature) : string
    {
        return \hash_hmac('sha256', $codeWithoutSignature, $this->hmacKey);
    }
    /**
     * {@inheritDoc}
     */
    public function verify(string $codeWithoutSignature, string $signature) : bool
    {
        return \hash_equals($this->encode($codeWithoutSignature), $signature);
    }
}
