<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\Roave\SignatureTest\Encoder;

use _PhpScoper26e51eeacccf\PHPUnit\Framework\TestCase;
use _PhpScoper26e51eeacccf\Roave\Signature\Encoder\Base64Encoder;
/**
 * @covers \Roave\Signature\Encoder\Base64Encoder
 */
final class Base64EncoderTest extends \_PhpScoper26e51eeacccf\PHPUnit\Framework\TestCase
{
    public function testEncode()
    {
        $encoder = new \_PhpScoper26e51eeacccf\Roave\Signature\Encoder\Base64Encoder();
        self::assertSame('IA==', $encoder->encode(' '));
        self::assertSame('PD9waHA=', $encoder->encode('<?php'));
    }
    public function testVerify()
    {
        $value = \uniqid('values', \true);
        self::assertTrue((new \_PhpScoper26e51eeacccf\Roave\Signature\Encoder\Base64Encoder())->verify($value, \base64_encode($value)));
    }
}
