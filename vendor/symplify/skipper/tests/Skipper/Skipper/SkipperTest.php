<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Skipper;

use Iterator;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use _PhpScopere8e811afab72\Symplify\Skipper\HttpKernel\SkipperKernel;
use _PhpScopere8e811afab72\Symplify\Skipper\Skipper\Skipper;
use _PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Skipper\Fixture\Element\FifthElement;
use _PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Skipper\Fixture\Element\SixthSense;
use _PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Skipper\Fixture\Element\ThreeMan;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class SkipperTest extends \_PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var Skipper
     */
    private $skipper;
    protected function setUp() : void
    {
        $this->bootKernelWithConfigs(\_PhpScopere8e811afab72\Symplify\Skipper\HttpKernel\SkipperKernel::class, [__DIR__ . '/config/config.php']);
        $this->skipper = $this->getService(\_PhpScopere8e811afab72\Symplify\Skipper\Skipper\Skipper::class);
    }
    /**
     * @dataProvider provideDataShouldSkipFileInfo()
     */
    public function testSkipFileInfo(string $filePath, bool $expectedSkip) : void
    {
        $smartFileInfo = new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo($filePath);
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
        (yield [\_PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Skipper\Fixture\Element\ThreeMan::class, \false]);
        (yield [\_PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Skipper\Fixture\Element\SixthSense::class, \true]);
        (yield [new \_PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Skipper\Fixture\Element\FifthElement(), \true]);
    }
}
