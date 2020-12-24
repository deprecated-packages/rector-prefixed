<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\Tests\FileSystemFilter;

use _PhpScoperb75b35f52b74\PHPUnit\Framework\TestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\FileSystemFilter;
final class FileSystemFilterTest extends \_PhpScoperb75b35f52b74\PHPUnit\Framework\TestCase
{
    /**
     * @var FileSystemFilter
     */
    private $fileSystemFilter;
    protected function setUp() : void
    {
        $this->fileSystemFilter = new \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\FileSystemFilter();
    }
    public function testSeparateFilesAndDirectories() : void
    {
        $sources = [__DIR__, __DIR__ . '/FileSystemFilterTest.php'];
        $files = $this->fileSystemFilter->filterFiles($sources);
        $directories = $this->fileSystemFilter->filterDirectories($sources);
        $this->assertCount(1, $files);
        $this->assertCount(1, $directories);
        $this->assertSame($files, [__DIR__ . '/FileSystemFilterTest.php']);
        $this->assertSame($directories, [__DIR__]);
    }
}
