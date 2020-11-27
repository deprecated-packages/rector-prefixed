<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Roave\SignatureTest\Encoder;

use _PhpScoperbd5d0c5f7638\PHPUnit\Framework\TestCase;
use _PhpScoperbd5d0c5f7638\Roave\Signature\Encoder\HmacEncoder;
/**
 * @covers \Roave\Signature\Encoder\HmacEncoder
 */
final class HmacEncoderTest extends \_PhpScoperbd5d0c5f7638\PHPUnit\Framework\TestCase
{
    public function testEncode()
    {
        $hmacKey = \random_bytes(64);
        $value = \uniqid('values', \true);
        self::assertSame(\hash_hmac('sha256', $value, $hmacKey), (new \_PhpScoperbd5d0c5f7638\Roave\Signature\Encoder\HmacEncoder($hmacKey))->encode($value));
    }
    public function testVerify()
    {
        $hmacKey = \random_bytes(64);
        $value = \uniqid('values', \true);
        self::assertTrue((new \_PhpScoperbd5d0c5f7638\Roave\Signature\Encoder\HmacEncoder($hmacKey))->verify($value, \hash_hmac('sha256', $value, $hmacKey)));
    }
}
