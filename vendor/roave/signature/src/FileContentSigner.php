<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Roave\Signature;

use _PhpScoperbd5d0c5f7638\Roave\Signature\Encoder\EncoderInterface;
final class FileContentSigner implements \_PhpScoperbd5d0c5f7638\Roave\Signature\SignerInterface
{
    /**
     * @var EncoderInterface
     */
    private $encoder;
    /**
     * {@inheritDoc}
     */
    public function __construct(\_PhpScoperbd5d0c5f7638\Roave\Signature\Encoder\EncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function sign(string $phpCode) : string
    {
        return 'Roave/Signature: ' . $this->encoder->encode($phpCode);
    }
}
