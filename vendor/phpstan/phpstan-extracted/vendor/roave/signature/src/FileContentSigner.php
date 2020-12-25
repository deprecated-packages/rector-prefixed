<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\Signature;

use _HumbugBox221ad6f1b81f\Roave\Signature\Encoder\EncoderInterface;
final class FileContentSigner implements \_HumbugBox221ad6f1b81f\Roave\Signature\SignerInterface
{
    /**
     * @var EncoderInterface
     */
    private $encoder;
    /**
     * {@inheritDoc}
     */
    public function __construct(\_HumbugBox221ad6f1b81f\Roave\Signature\Encoder\EncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function sign(string $phpCode) : string
    {
        return 'Roave/Signature: ' . $this->encoder->encode($phpCode);
    }
}
