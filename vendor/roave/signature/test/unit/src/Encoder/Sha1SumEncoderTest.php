<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Roave\SignatureTest\Encoder;

use _PhpScoper88fe6e0ad041\PHPUnit\Framework\TestCase;
use _PhpScoper88fe6e0ad041\Roave\Signature\Encoder\Sha1SumEncoder;
/**
 * @covers \Roave\Signature\Encoder\Sha1SumEncoder
 */
final class Sha1SumEncoderTest extends \_PhpScoper88fe6e0ad041\PHPUnit\Framework\TestCase
{
    public function testEncode()
    {
        $value = \uniqid('values', \true);
        self::assertSame(\sha1($value), (new \_PhpScoper88fe6e0ad041\Roave\Signature\Encoder\Sha1SumEncoder())->encode($value));
    }
    public function testVerify()
    {
        $value = \uniqid('values', \true);
        self::assertTrue((new \_PhpScoper88fe6e0ad041\Roave\Signature\Encoder\Sha1SumEncoder())->verify($value, \sha1($value)));
    }
}
