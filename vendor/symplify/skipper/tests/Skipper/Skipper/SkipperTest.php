<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\Skipper\Tests\Skipper\Skipper;

use Iterator;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use _PhpScoper0a6b37af0871\Symplify\Skipper\HttpKernel\SkipperKernel;
use _PhpScoper0a6b37af0871\Symplify\Skipper\Skipper\Skipper;
use _PhpScoper0a6b37af0871\Symplify\Skipper\Tests\Skipper\Skipper\Fixture\Element\FifthElement;
use _PhpScoper0a6b37af0871\Symplify\Skipper\Tests\Skipper\Skipper\Fixture\Element\SixthSense;
use _PhpScoper0a6b37af0871\Symplify\Skipper\Tests\Skipper\Skipper\Fixture\Element\ThreeMan;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class SkipperTest extends \_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
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
     * @dataProvider provideDataShouldSkipFileInfo()
     */
    public function testSkipFileInfo(string $filePath, bool $expectedSkip) : void
    {
        $smartFileInfo = new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo($filePath);
        $resultSkip = $this->skipper->shouldSkipFileInfo($smartFileInfo);
        $this->assertSame($expectedSkip, $resultSkip);
    }
    public function provideDataShouldSkipFileInfo() : \Iterator
    {
        (yield [__DIR__ . '/Fixture/SomeRandom/file.txt', \false]);
        (yield [__DIR__ . '/Fixture/SomeSkipped/any.txt', \true]);
    }
    /**
     * @dataProvider provideDataShouldSkipElement()
     */
    public function testSkipElement($element, bool $expectedSkip) : void
    {
        $resultSkip = $this->skipper->shouldSkipElement($element);
        $this->assertSame($expectedSkip, $resultSkip);
    }
    public function provideDataShouldSkipElement() : \Iterator
    {
        (yield [\_PhpScoper0a6b37af0871\Symplify\Skipper\Tests\Skipper\Skipper\Fixture\Element\ThreeMan::class, \false]);
        (yield [\_PhpScoper0a6b37af0871\Symplify\Skipper\Tests\Skipper\Skipper\Fixture\Element\SixthSense::class, \true]);
        (yield [new \_PhpScoper0a6b37af0871\Symplify\Skipper\Tests\Skipper\Skipper\Fixture\Element\FifthElement(), \true]);
    }
}
