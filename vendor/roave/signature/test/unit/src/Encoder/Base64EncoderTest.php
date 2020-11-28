<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Roave\SignatureTest\Encoder;

use _PhpScoperabd03f0baf05\PHPUnit\Framework\TestCase;
use _PhpScoperabd03f0baf05\Roave\Signature\Encoder\Base64Encoder;
/**
 * @covers \Roave\Signature\Encoder\Base64Encoder
 */
final class Base64EncoderTest extends \_PhpScoperabd03f0baf05\PHPUnit\Framework\TestCase
{
    public function testEncode()
    {
        $encoder = new \_PhpScoperabd03f0baf05\Roave\Signature\Encoder\Base64Encoder();
        self::assertSame('IA==', $encoder->encode(' '));
        self::assertSame('PD9waHA=', $encoder->encode('<?php'));
    }
    public function testVerify()
    {
        $value = \uniqid('values', \true);
        self::assertTrue((new \_PhpScoperabd03f0baf05\Roave\Signature\Encoder\Base64Encoder())->verify($value, \base64_encode($value)));
    }
}
