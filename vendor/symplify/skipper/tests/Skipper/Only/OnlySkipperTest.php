<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Only;

use Iterator;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use _PhpScopere8e811afab72\Symplify\Skipper\HttpKernel\SkipperKernel;
use _PhpScopere8e811afab72\Symplify\Skipper\Skipper\Skipper;
use _PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Only\Source\IncludeThisClass;
use _PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Only\Source\SkipCompletely;
use _PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Only\Source\SkipCompletelyToo;
use _PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Only\Source\SkipThisClass;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class OnlySkipperTest extends \_PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
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
     * @dataProvider provideCheckerAndFile()
     */
    public function testCheckerAndFile(string $class, string $filePath, bool $expected) : void
    {
        $resolvedSkip = $this->skipper->shouldSkipElementAndFileInfo($class, new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo($filePath));
        $this->assertSame($expected, $resolvedSkip);
    }
    public function provideCheckerAndFile() : \Iterator
    {
        (yield [\_PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Only\Source\IncludeThisClass::class, __DIR__ . '/Fixture/SomeFileToOnlyInclude.php', \false]);
        (yield [\_PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Only\Source\IncludeThisClass::class, __DIR__ . '/Fixture/SomeFile.php', \true]);
        // no restrictions
        (yield [\_PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Only\Source\SkipThisClass::class, __DIR__ . '/Fixture/SomeFileToOnlyInclude.php', \false]);
        (yield [\_PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Only\Source\SkipThisClass::class, __DIR__ . '/Fixture/SomeFile.php', \false]);
        (yield [\_PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Only\Source\SkipCompletely::class, __DIR__ . '/Fixture/SomeFile.php', \true]);
        (yield [\_PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Only\Source\SkipCompletelyToo::class, __DIR__ . '/Fixture/SomeFile.php', \true]);
    }
}
