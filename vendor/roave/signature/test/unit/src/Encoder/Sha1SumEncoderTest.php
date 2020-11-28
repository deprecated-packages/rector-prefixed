<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Roave\SignatureTest\Encoder;

use _PhpScoperabd03f0baf05\PHPUnit\Framework\TestCase;
use _PhpScoperabd03f0baf05\Roave\Signature\Encoder\Sha1SumEncoder;
/**
 * @covers \Roave\Signature\Encoder\Sha1SumEncoder
 */
final class Sha1SumEncoderTest extends \_PhpScoperabd03f0baf05\PHPUnit\Framework\TestCase
{
    public function testEncode()
    {
        $value = \uniqid('values', \true);
        self::assertSame(\sha1($value), (new \_PhpScoperabd03f0baf05\Roave\Signature\Encoder\Sha1SumEncoder())->encode($value));
    }
    public function testVerify()
    {
        $value = \uniqid('values', \true);
        self::assertTrue((new \_PhpScoperabd03f0baf05\Roave\Signature\Encoder\Sha1SumEncoder())->verify($value, \sha1($value)));
    }
}
