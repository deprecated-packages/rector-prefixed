<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\Skipper\Tests\Skipper\Skip;

use Iterator;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use _PhpScoper0a6b37af0871\Symplify\Skipper\HttpKernel\SkipperKernel;
use _PhpScoper0a6b37af0871\Symplify\Skipper\Skipper\Skipper;
use _PhpScoper0a6b37af0871\Symplify\Skipper\Tests\Skipper\Skip\Source\AnotherClassToSkip;
use _PhpScoper0a6b37af0871\Symplify\Skipper\Tests\Skipper\Skip\Source\NotSkippedClass;
use _PhpScoper0a6b37af0871\Symplify\Skipper\Tests\Skipper\Skip\Source\SomeClassToSkip;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class SkipSkipperTest extends \_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var Skipper
     */
    private $skipper;
    protected function setUp() : void
    {
        $this->bootKernelWithConfigs(\_PhpScoper0a6b37af0871\Symplify\Skipper\HttpKernel\SkipperKernel::class, [__DIR__ . '/config/config.php']);
        $this->skipper = $this->getService(\_PhpScoper0a6b37af0871\Symplify\Skipper\Skipper\Skipper::class);
    }
    /**
     * @dataProvider provideCheckerAndFile()
     * @dataProvider provideCodeAndFile()
     * @dataProvider provideMessageAndFile()
     * @dataProvider provideAnythingAndFilePath()
     */
    public function test(string $element, string $filePath, bool $expectedSkip) : void
    {
        $resolvedSkip = $this->skipper->shouldSkipElementAndFileInfo($element, new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo($filePath));
        $this->assertSame($expectedSkip, $resolvedSkip);
    }
    public function provideCheckerAndFile() : \Iterator
    {
        (yield [\_PhpScoper0a6b37af0871\Symplify\Skipper\Tests\Skipper\Skip\Source\SomeClassToSkip::class, __DIR__ . '/Fixture', \true]);
        (yield [\_PhpScoper0a6b37af0871\Symplify\Skipper\Tests\Skipper\Skip\Source\AnotherClassToSkip::class, __DIR__ . '/Fixture/someFile', \true]);
        (yield [\_PhpScoper0a6b37af0871\Symplify\Skipper\Tests\Skipper\Skip\Source\AnotherClassToSkip::class, __DIR__ . '/Fixture/someDirectory/anotherFile.php', \true]);
        (yield [\_PhpScoper0a6b37af0871\Symplify\Skipper\Tests\Skipper\Skip\Source\AnotherClassToSkip::class, __DIR__ . '/Fixture/someDirectory/anotherFile.php', \true]);
        (yield [\_PhpScoper0a6b37af0871\Symplify\Skipper\Tests\Skipper\Skip\Source\NotSkippedClass::class, __DIR__ . '/Fixture/someFile', \false]);
        (yield [\_PhpScoper0a6b37af0871\Symplify\Skipper\Tests\Skipper\Skip\Source\NotSkippedClass::class, __DIR__ . '/Fixture/someOtherFile', \false]);
    }
    public function provideCodeAndFile() : \Iterator
    {
        (yield [\_PhpScoper0a6b37af0871\Symplify\Skipper\Tests\Skipper\Skip\Source\AnotherClassToSkip::class . '.someCode', __DIR__ . '/Fixture/someFile', \true]);
        (yield [\_PhpScoper0a6b37af0871\Symplify\Skipper\Tests\Skipper\Skip\Source\AnotherClassToSkip::class . '.someOtherCode', __DIR__ . '/Fixture/someDirectory/someFile', \true]);
        (yield [\_PhpScoper0a6b37af0871\Symplify\Skipper\Tests\Skipper\Skip\Source\AnotherClassToSkip::class . '.someAnotherCode', __DIR__ . '/Fixture/someDirectory/someFile', \true]);
        (yield ['someSniff.someForeignCode', __DIR__ . '/Fixture/someFile', \false]);
        (yield ['someSniff.someOtherCode', __DIR__ . '/Fixture/someFile', \false]);
    }
    public function provideMessageAndFile() : \Iterator
    {
        (yield ['some fishy code at line 5!', __DIR__ . '/Fixture/someFile', \true]);
        (yield ['some another fishy code at line 5!', __DIR__ . '/Fixture/someDirectory/someFile.php', \true]);
        (yield ['Cognitive complexity for method "foo" is 2 but has to be less than or equal to 1.', __DIR__ . '/Fixture/skip.php.inc', \true]);
        (yield ['Cognitive complexity for method "bar" is 2 but has to be less than or equal to 1.', __DIR__ . '/Fixture/skip.php.inc', \false]);
    }
    public function provideAnythingAndFilePath() : \Iterator
    {
        (yield ['anything', __DIR__ . '/Fixture/AlwaysSkippedPath/some_file.txt', \true]);
        (yield ['anything', __DIR__ . '/Fixture/PathSkippedWithMask/another_file.txt', \true]);
    }
}
