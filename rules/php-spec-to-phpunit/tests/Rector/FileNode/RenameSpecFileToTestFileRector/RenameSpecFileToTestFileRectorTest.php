<?php

declare (strict_types=1);
namespace Rector\PhpSpecToPHPUnit\Tests\Rector\FileNode\RenameSpecFileToTestFileRector;

use Iterator;
use _PhpScoper006a73f0e455\Nette\Utils\Strings;
use Rector\FileSystemRector\Contract\MovedFileInterface;
use Rector\PhpSpecToPHPUnit\Rector\FileNode\RenameSpecFileToTestFileRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
final class RenameSpecFileToTestFileRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
        // test file is moved
        $movedFile = $this->matchMovedFile($this->originalTempFileInfo);
        $this->assertInstanceOf(\Rector\FileSystemRector\Contract\MovedFileInterface::class, $movedFile);
        $this->assertTrue(\_PhpScoper006a73f0e455\Nette\Utils\Strings::endsWith($movedFile->getNewPathname(), 'Test.php'));
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture', '*.php');
    }
    protected function getRectorClass() : string
    {
        return \Rector\PhpSpecToPHPUnit\Rector\FileNode\RenameSpecFileToTestFileRector::class;
    }
}
