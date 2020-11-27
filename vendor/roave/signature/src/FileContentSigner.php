<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Roave\Signature;

use _PhpScopera143bcca66cb\Roave\Signature\Encoder\EncoderInterface;
final class FileContentSigner implements \_PhpScopera143bcca66cb\Roave\Signature\SignerInterface
{
    /**
     * @var EncoderInterface
     */
    private $encoder;
    /**
     * {@inheritDoc}
     */
    public function __construct(\_PhpScopera143bcca66cb\Roave\Signature\Encoder\EncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function sign(string $phpCode) : string
    {
        return 'Roave/Signature: ' . $this->encoder->encode($phpCode);
    }
}
