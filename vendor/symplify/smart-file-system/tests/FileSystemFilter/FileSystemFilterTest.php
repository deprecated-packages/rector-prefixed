<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\Tests\FileSystemFilter;

use _PhpScoper0a6b37af0871\PHPUnit\Framework\TestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\FileSystemFilter;
final class FileSystemFilterTest extends \_PhpScoper0a6b37af0871\PHPUnit\Framework\TestCase
{
    /**
     * @var FileSystemFilter
     */
    private $fileSystemFilter;
    protected function setUp() : void
    {
        $this->fileSystemFilter = new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\FileSystemFilter();
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
