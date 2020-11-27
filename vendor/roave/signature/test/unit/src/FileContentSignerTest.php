<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Roave\SignatureTest;

use _PhpScoper88fe6e0ad041\PHPUnit\Framework\TestCase;
use _PhpScoper88fe6e0ad041\Roave\Signature\Encoder\Base64Encoder;
use _PhpScoper88fe6e0ad041\Roave\Signature\FileContentSigner;
/**
 * @covers \Roave\Signature\FileContentSigner
 */
final class FileContentSignerTest extends \_PhpScoper88fe6e0ad041\PHPUnit\Framework\TestCase
{
    /**
     * @return string[][]
     */
    public function signProvider() : array
    {
        return [['Roave/Signature: PD9waHA=', '<?php'], ['Roave/Signature: PD9waHAK', '<?php' . "\n"], ['Roave/Signature: PGh0bWw+', '<html>'], ['Roave/Signature: cGxhaW4gdGV4dA==', 'plain text']];
    }
    /**
     * @dataProvider signProvider
     */
    public function testSign(string $expected, string $inputString) : void
    {
        $signer = new \_PhpScoper88fe6e0ad041\Roave\Signature\FileContentSigner(new \_PhpScoper88fe6e0ad041\Roave\Signature\Encoder\Base64Encoder());
        self::assertSame($expected, $signer->sign($inputString));
    }
}
