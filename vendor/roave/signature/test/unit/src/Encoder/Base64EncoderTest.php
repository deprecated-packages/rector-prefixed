<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Roave\SignatureTest\Encoder;

use _PhpScopera143bcca66cb\PHPUnit\Framework\TestCase;
use _PhpScopera143bcca66cb\Roave\Signature\Encoder\Base64Encoder;
/**
 * @covers \Roave\Signature\Encoder\Base64Encoder
 */
final class Base64EncoderTest extends \_PhpScopera143bcca66cb\PHPUnit\Framework\TestCase
{
    public function testEncode()
    {
        $encoder = new \_PhpScopera143bcca66cb\Roave\Signature\Encoder\Base64Encoder();
        self::assertSame('IA==', $encoder->encode(' '));
        self::assertSame('PD9waHA=', $encoder->encode('<?php'));
    }
    public function testVerify()
    {
        $value = \uniqid('values', \true);
        self::assertTrue((new \_PhpScopera143bcca66cb\Roave\Signature\Encoder\Base64Encoder())->verify($value, \base64_encode($value)));
    }
}
