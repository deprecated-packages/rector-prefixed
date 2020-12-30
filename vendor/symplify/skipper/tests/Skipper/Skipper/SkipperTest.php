<?php

declare (strict_types=1);
namespace RectorPrefix20201230\Symplify\Skipper\Tests\Skipper\Skipper;

use Iterator;
use RectorPrefix20201230\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use RectorPrefix20201230\Symplify\Skipper\HttpKernel\SkipperKernel;
use RectorPrefix20201230\Symplify\Skipper\Skipper\Skipper;
use RectorPrefix20201230\Symplify\Skipper\Tests\Skipper\Skipper\Fixture\Element\FifthElement;
use RectorPrefix20201230\Symplify\Skipper\Tests\Skipper\Skipper\Fixture\Element\SixthSense;
use RectorPrefix20201230\Symplify\Skipper\Tests\Skipper\Skipper\Fixture\Element\ThreeMan;
use RectorPrefix20201230\Symplify\SmartFileSystem\SmartFileInfo;
final class SkipperTest extends \RectorPrefix20201230\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var Skipper
     */
    private $skipper;
    protected function setUp() : void
    {
        $this->bootKernelWithConfigs(\RectorPrefix20201230\Symplify\Skipper\HttpKernel\SkipperKernel::class, [__DIR__ . '/config/config.php']);
        $this->skipper = $this->getService(\RectorPrefix20201230\Symplify\Skipper\Skipper\Skipper::class);
    }
    /**
     * @dataProvider provideDataShouldSkipFileInfo()
     */
    public function testSkipFileInfo(string $filePath, bool $expectedSkip) : void
    {
        $smartFileInfo = new \RectorPrefix20201230\Symplify\SmartFileSystem\SmartFileInfo($filePath);
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
        (yield [\RectorPrefix20201230\Symplify\Skipper\Tests\Skipper\Skipper\Fixture\Element\ThreeMan::class, \false]);
        (yield [\RectorPrefix20201230\Symplify\Skipper\Tests\Skipper\Skipper\Fixture\Element\SixthSense::class, \true]);
        (yield [new \RectorPrefix20201230\Symplify\Skipper\Tests\Skipper\Skipper\Fixture\Element\FifthElement(), \true]);
    }
}
