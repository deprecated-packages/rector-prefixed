<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Roave\Signature;

use _PhpScoper006a73f0e455\Roave\Signature\Encoder\EncoderInterface;
final class FileContentSigner implements \_PhpScoper006a73f0e455\Roave\Signature\SignerInterface
{
    /**
     * @var EncoderInterface
     */
    private $encoder;
    /**
     * {@inheritDoc}
     */
    public function __construct(\_PhpScoper006a73f0e455\Roave\Signature\Encoder\EncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function sign(string $phpCode) : string
    {
        return 'Roave/Signature: ' . $this->encoder->encode($phpCode);
    }
}
