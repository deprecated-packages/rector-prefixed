<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Roave\SignatureTest;

use _PhpScoper006a73f0e455\PHPUnit\Framework\TestCase;
use _PhpScoper006a73f0e455\Roave\Signature\Encoder\Base64Encoder;
use _PhpScoper006a73f0e455\Roave\Signature\Encoder\EncoderInterface;
use _PhpScoper006a73f0e455\Roave\Signature\FileContentChecker;
/**
 * @covers \Roave\Signature\FileContentChecker
 */
final class FileContentCheckerTest extends \_PhpScoper006a73f0e455\PHPUnit\Framework\TestCase
{
    /**
     * @var EncoderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $encoder;
    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        parent::setUp();
        $this->encoder = $this->createMock(\_PhpScoper006a73f0e455\Roave\Signature\Encoder\EncoderInterface::class);
    }
    public function testShouldCheckClassFileContent()
    {
        $classFilePath = __DIR__ . '/../../fixture/UserClassSignedByFileContent.php';
        self::assertFileExists($classFilePath);
        $checker = new \_PhpScoper006a73f0e455\Roave\Signature\FileContentChecker(new \_PhpScoper006a73f0e455\Roave\Signature\Encoder\Base64Encoder());
        $checker->check(\file_get_contents($classFilePath));
    }
    public function testShouldReturnFalseIfSignatureDoesNotMatch()
    {
        $classFilePath = __DIR__ . '/../../fixture/UserClassSignedByFileContent.php';
        self::assertFileExists($classFilePath);
        $expectedSignature = 'YToxOntpOjA7czoxNDE6Ijw/cGhwCgpuYW1lc3BhY2UgU2lnbmF0dXJlVGVzdEZpeHR1cmU7' . 'CgpjbGFzcyBVc2VyQ2xhc3NTaWduZWRCeUZpbGVDb250ZW50CnsKICAgIHB1YmxpYyAkbmFtZTsKCiAgICBwcm90ZW' . 'N0ZWQgJHN1cm5hbWU7CgogICAgcHJpdmF0ZSAkYWdlOwp9CiI7fQ==';
        $this->encoder->expects(self::once())->method('verify')->with(\str_replace('/** Roave/Signature: ' . $expectedSignature . ' */' . "\n", '', \file_get_contents($classFilePath)), $expectedSignature);
        $checker = new \_PhpScoper006a73f0e455\Roave\Signature\FileContentChecker($this->encoder);
        self::assertFalse($checker->check(\file_get_contents($classFilePath)));
    }
    public function testShouldReturnFalseIfClassIsNotSigned()
    {
        $classFilePath = __DIR__ . '/../../fixture/UserClass.php';
        self::assertFileExists($classFilePath);
        $checker = new \_PhpScoper006a73f0e455\Roave\Signature\FileContentChecker($this->encoder);
        self::assertFalse($checker->check(\file_get_contents($classFilePath)));
    }
}
