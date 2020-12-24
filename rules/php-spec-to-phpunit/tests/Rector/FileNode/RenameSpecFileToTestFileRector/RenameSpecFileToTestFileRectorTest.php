<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit\Tests\Rector\FileNode\RenameSpecFileToTestFileRector;

use Iterator;
use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\Rector\FileSystemRector\Contract\MovedFileInterface;
use _PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit\Rector\FileNode\RenameSpecFileToTestFileRector;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameSpecFileToTestFileRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
        // test file is moved
        $movedFile = $this->matchMovedFile($this->originalTempFileInfo);
        $this->assertInstanceOf(\_PhpScoper0a6b37af0871\Rector\FileSystemRector\Contract\MovedFileInterface::class, $movedFile);
        $this->assertTrue(\_PhpScoper0a6b37af0871\Nette\Utils\Strings::endsWith($movedFile->getNewPathname(), 'Test.php'));
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture', '*.php');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit\Rector\FileNode\RenameSpecFileToTestFileRector::class;
    }
}
