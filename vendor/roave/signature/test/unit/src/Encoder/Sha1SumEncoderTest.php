<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Roave\SignatureTest\Encoder;

use _PhpScoper006a73f0e455\PHPUnit\Framework\TestCase;
use _PhpScoper006a73f0e455\Roave\Signature\Encoder\Sha1SumEncoder;
/**
 * @covers \Roave\Signature\Encoder\Sha1SumEncoder
 */
final class Sha1SumEncoderTest extends \_PhpScoper006a73f0e455\PHPUnit\Framework\TestCase
{
    public function testEncode()
    {
        $value = \uniqid('values', \true);
        self::assertSame(\sha1($value), (new \_PhpScoper006a73f0e455\Roave\Signature\Encoder\Sha1SumEncoder())->encode($value));
    }
    public function testVerify()
    {
        $value = \uniqid('values', \true);
        self::assertTrue((new \_PhpScoper006a73f0e455\Roave\Signature\Encoder\Sha1SumEncoder())->verify($value, \sha1($value)));
    }
}
