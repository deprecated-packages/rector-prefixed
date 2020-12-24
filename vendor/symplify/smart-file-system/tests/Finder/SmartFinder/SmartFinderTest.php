<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\Tests\Finder\SmartFinder;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\PHPUnit\Framework\TestCase;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\FileSystemFilter;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\Finder\FinderSanitizer;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\Finder\SmartFinder;
final class SmartFinderTest extends \_PhpScoper2a4e7ab1ecbc\PHPUnit\Framework\TestCase
{
    /**
     * @var SmartFinder
     */
    private $smartFinder;
    protected function setUp() : void
    {
        $this->smartFinder = new \_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\Finder\SmartFinder(new \_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\Finder\FinderSanitizer(), new \_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\FileSystemFilter());
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
