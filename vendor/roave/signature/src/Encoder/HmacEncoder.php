<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Roave\Signature\Encoder;

final class HmacEncoder implements \_PhpScoper006a73f0e455\Roave\Signature\Encoder\EncoderInterface
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
