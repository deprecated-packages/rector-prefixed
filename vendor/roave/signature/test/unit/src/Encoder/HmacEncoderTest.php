<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Roave\SignatureTest\Encoder;

use _PhpScoper006a73f0e455\PHPUnit\Framework\TestCase;
use _PhpScoper006a73f0e455\Roave\Signature\Encoder\HmacEncoder;
/**
 * @covers \Roave\Signature\Encoder\HmacEncoder
 */
final class HmacEncoderTest extends \_PhpScoper006a73f0e455\PHPUnit\Framework\TestCase
{
    public function testEncode()
    {
        $hmacKey = \random_bytes(64);
        $value = \uniqid('values', \true);
        self::assertSame(\hash_hmac('sha256', $value, $hmacKey), (new \_PhpScoper006a73f0e455\Roave\Signature\Encoder\HmacEncoder($hmacKey))->encode($value));
    }
    public function testVerify()
    {
        $hmacKey = \random_bytes(64);
        $value = \uniqid('values', \true);
        self::assertTrue((new \_PhpScoper006a73f0e455\Roave\Signature\Encoder\HmacEncoder($hmacKey))->verify($value, \hash_hmac('sha256', $value, $hmacKey)));
    }
}
