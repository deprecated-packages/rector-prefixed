<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\Tests\Finder\SmartFinder;

use Iterator;
use _PhpScoperb75b35f52b74\PHPUnit\Framework\TestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\FileSystemFilter;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\Finder\FinderSanitizer;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\Finder\SmartFinder;
final class SmartFinderTest extends \_PhpScoperb75b35f52b74\PHPUnit\Framework\TestCase
{
    /**
     * @var SmartFinder
     */
    private $smartFinder;
    protected function setUp() : void
    {
        $this->smartFinder = new \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\Finder\SmartFinder(new \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\Finder\FinderSanitizer(), new \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\FileSystemFilter());
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
