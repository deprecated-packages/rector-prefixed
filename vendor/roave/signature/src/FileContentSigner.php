<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Roave\Signature;

use _PhpScoperabd03f0baf05\Roave\Signature\Encoder\EncoderInterface;
final class FileContentSigner implements \_PhpScoperabd03f0baf05\Roave\Signature\SignerInterface
{
    /**
     * @var EncoderInterface
     */
    private $encoder;
    /**
     * {@inheritDoc}
     */
    public function __construct(\_PhpScoperabd03f0baf05\Roave\Signature\Encoder\EncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function sign(string $phpCode) : string
    {
        return 'Roave/Signature: ' . $this->encoder->encode($phpCode);
    }
}
