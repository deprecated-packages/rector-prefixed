<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Roave\SignatureTest\Encoder;

use _PhpScoperbd5d0c5f7638\PHPUnit\Framework\TestCase;
use _PhpScoperbd5d0c5f7638\Roave\Signature\Encoder\Sha1SumEncoder;
/**
 * @covers \Roave\Signature\Encoder\Sha1SumEncoder
 */
final class Sha1SumEncoderTest extends \_PhpScoperbd5d0c5f7638\PHPUnit\Framework\TestCase
{
    public function testEncode()
    {
        $value = \uniqid('values', \true);
        self::assertSame(\sha1($value), (new \_PhpScoperbd5d0c5f7638\Roave\Signature\Encoder\Sha1SumEncoder())->encode($value));
    }
    public function testVerify()
    {
        $value = \uniqid('values', \true);
        self::assertTrue((new \_PhpScoperbd5d0c5f7638\Roave\Signature\Encoder\Sha1SumEncoder())->verify($value, \sha1($value)));
    }
}
