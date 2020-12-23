<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\Tests\Finder\SmartFinder;

use Iterator;
use _PhpScoper0a2ac50786fa\PHPUnit\Framework\TestCase;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\FileSystemFilter;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\Finder\FinderSanitizer;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\Finder\SmartFinder;
final class SmartFinderTest extends \_PhpScoper0a2ac50786fa\PHPUnit\Framework\TestCase
{
    /**
     * @var SmartFinder
     */
    private $smartFinder;
    protected function setUp() : void
    {
        $this->smartFinder = new \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\Finder\SmartFinder(new \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\Finder\FinderSanitizer(), new \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\FileSystemFilter());
    }
    /**
     * @dataProvider provideData()
     */
    public function test(array $paths, string $suffix, int $expectedCount) : void
    {
        $fileInfos = $this->smartFinder->find($paths, $suffix);
        $this->assertCount($expectedCount, $fileInfos);
    }
    public function provideData() : \Iterator
    {
        (yield [[__DIR__ . '/Fixture'], '*.twig', 2]);
        (yield [[__DIR__ . '/Fixture'], '*.txt', 1]);
        (yield [[__DIR__ . '/Fixture/some_file.twig'], '*.txt', 1]);
        (yield [[__DIR__ . '/Fixture/some_file.twig', __DIR__ . '/Fixture/nested_path'], '*.txt', 2]);
    }
}
