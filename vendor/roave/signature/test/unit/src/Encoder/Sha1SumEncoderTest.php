<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Roave\SignatureTest\Encoder;

use _PhpScopera143bcca66cb\PHPUnit\Framework\TestCase;
use _PhpScopera143bcca66cb\Roave\Signature\Encoder\Sha1SumEncoder;
/**
 * @covers \Roave\Signature\Encoder\Sha1SumEncoder
 */
final class Sha1SumEncoderTest extends \_PhpScopera143bcca66cb\PHPUnit\Framework\TestCase
{
    public function testEncode()
    {
        $value = \uniqid('values', \true);
        self::assertSame(\sha1($value), (new \_PhpScopera143bcca66cb\Roave\Signature\Encoder\Sha1SumEncoder())->encode($value));
    }
    public function testVerify()
    {
        $value = \uniqid('values', \true);
        self::assertTrue((new \_PhpScopera143bcca66cb\Roave\Signature\Encoder\Sha1SumEncoder())->verify($value, \sha1($value)));
    }
}
