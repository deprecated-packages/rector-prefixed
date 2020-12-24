<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\Signature;

use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\Signature\Encoder\EncoderInterface;
final class FileContentSigner implements \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\Signature\SignerInterface
{
    /**
     * @var EncoderInterface
     */
    private $encoder;
    /**
     * {@inheritDoc}
     */
    public function __construct(\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\Signature\Encoder\EncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function sign(string $phpCode) : string
    {
        return 'Roave/Signature: ' . $this->encoder->encode($phpCode);
    }
}
