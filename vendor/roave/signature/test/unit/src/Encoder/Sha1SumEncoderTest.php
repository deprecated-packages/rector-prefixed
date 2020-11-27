<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\Roave\SignatureTest\Encoder;

use _PhpScoper26e51eeacccf\PHPUnit\Framework\TestCase;
use _PhpScoper26e51eeacccf\Roave\Signature\Encoder\Sha1SumEncoder;
/**
 * @covers \Roave\Signature\Encoder\Sha1SumEncoder
 */
final class Sha1SumEncoderTest extends \_PhpScoper26e51eeacccf\PHPUnit\Framework\TestCase
{
    public function testEncode()
    {
        $value = \uniqid('values', \true);
        self::assertSame(\sha1($value), (new \_PhpScoper26e51eeacccf\Roave\Signature\Encoder\Sha1SumEncoder())->encode($value));
    }
    public function testVerify()
    {
        $value = \uniqid('values', \true);
        self::assertTrue((new \_PhpScoper26e51eeacccf\Roave\Signature\Encoder\Sha1SumEncoder())->verify($value, \sha1($value)));
    }
}
