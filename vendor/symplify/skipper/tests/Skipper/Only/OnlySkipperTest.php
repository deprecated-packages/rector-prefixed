<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\Skipper\Tests\Skipper\Only;

use Iterator;
use _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use _PhpScoper0a2ac50786fa\Symplify\Skipper\HttpKernel\SkipperKernel;
use _PhpScoper0a2ac50786fa\Symplify\Skipper\Skipper\Skipper;
use _PhpScoper0a2ac50786fa\Symplify\Skipper\Tests\Skipper\Only\Source\IncludeThisClass;
use _PhpScoper0a2ac50786fa\Symplify\Skipper\Tests\Skipper\Only\Source\SkipCompletely;
use _PhpScoper0a2ac50786fa\Symplify\Skipper\Tests\Skipper\Only\Source\SkipCompletelyToo;
use _PhpScoper0a2ac50786fa\Symplify\Skipper\Tests\Skipper\Only\Source\SkipThisClass;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class OnlySkipperTest extends \_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var Skipper
     */
    private $skipper;
    protected function setUp() : void
    {
        $this->bootKernelWithConfigs(\_PhpScoper0a2ac50786fa\Symplify\Skipper\HttpKernel\SkipperKernel::class, [__DIR__ . '/config/config.php']);
        $this->skipper = $this->getService(\_PhpScoper0a2ac50786fa\Symplify\Skipper\Skipper\Skipper::class);
    }
    /**
     * @dataProvider provideCheckerAndFile()
     */
    public function testCheckerAndFile(string $class, string $filePath, bool $expected) : void
    {
        $resolvedSkip = $this->skipper->shouldSkipElementAndFileInfo($class, new \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo($filePath));
        $this->assertSame($expected, $resolvedSkip);
    }
    public function provideCheckerAndFile() : \Iterator
    {
        (yield [\_PhpScoper0a2ac50786fa\Symplify\Skipper\Tests\Skipper\Only\Source\IncludeThisClass::class, __DIR__ . '/Fixture/SomeFileToOnlyInclude.php', \false]);
        (yield [\_PhpScoper0a2ac50786fa\Symplify\Skipper\Tests\Skipper\Only\Source\IncludeThisClass::class, __DIR__ . '/Fixture/SomeFile.php', \true]);
        // no restrictions
        (yield [\_PhpScoper0a2ac50786fa\Symplify\Skipper\Tests\Skipper\Only\Source\SkipThisClass::class, __DIR__ . '/Fixture/SomeFileToOnlyInclude.php', \false]);
        (yield [\_PhpScoper0a2ac50786fa\Symplify\Skipper\Tests\Skipper\Only\Source\SkipThisClass::class, __DIR__ . '/Fixture/SomeFile.php', \false]);
        (yield [\_PhpScoper0a2ac50786fa\Symplify\Skipper\Tests\Skipper\Only\Source\SkipCompletely::class, __DIR__ . '/Fixture/SomeFile.php', \true]);
        (yield [\_PhpScoper0a2ac50786fa\Symplify\Skipper\Tests\Skipper\Only\Source\SkipCompletelyToo::class, __DIR__ . '/Fixture/SomeFile.php', \true]);
    }
}
