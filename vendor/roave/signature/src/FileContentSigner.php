<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Roave\Signature;

use _PhpScoper88fe6e0ad041\Roave\Signature\Encoder\EncoderInterface;
final class FileContentSigner implements \_PhpScoper88fe6e0ad041\Roave\Signature\SignerInterface
{
    /**
     * @var EncoderInterface
     */
    private $encoder;
    /**
     * {@inheritDoc}
     */
    public function __construct(\_PhpScoper88fe6e0ad041\Roave\Signature\Encoder\EncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function sign(string $phpCode) : string
    {
        return 'Roave/Signature: ' . $this->encoder->encode($phpCode);
    }
}
