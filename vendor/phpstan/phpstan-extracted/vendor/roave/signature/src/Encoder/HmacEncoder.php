<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\Signature\Encoder;

final class HmacEncoder implements \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\Signature\Encoder\EncoderInterface
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
