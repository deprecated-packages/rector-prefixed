<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Roave\SignatureTest\Encoder;

use _PhpScopera143bcca66cb\PHPUnit\Framework\TestCase;
use _PhpScopera143bcca66cb\Roave\Signature\Encoder\HmacEncoder;
/**
 * @covers \Roave\Signature\Encoder\HmacEncoder
 */
final class HmacEncoderTest extends \_PhpScopera143bcca66cb\PHPUnit\Framework\TestCase
{
    public function testEncode()
    {
        $hmacKey = \random_bytes(64);
        $value = \uniqid('values', \true);
        self::assertSame(\hash_hmac('sha256', $value, $hmacKey), (new \_PhpScopera143bcca66cb\Roave\Signature\Encoder\HmacEncoder($hmacKey))->encode($value));
    }
    public function testVerify()
    {
        $hmacKey = \random_bytes(64);
        $value = \uniqid('values', \true);
        self::assertTrue((new \_PhpScopera143bcca66cb\Roave\Signature\Encoder\HmacEncoder($hmacKey))->verify($value, \hash_hmac('sha256', $value, $hmacKey)));
    }
}
