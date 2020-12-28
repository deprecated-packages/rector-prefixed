<?php

declare (strict_types=1);
namespace Rector\Restoration\Tests\Rector\ClassLike\UpdateFileNameByClassNameFileSystemRector;

use Iterator;
use Rector\Restoration\Rector\ClassLike\UpdateFileNameByClassNameFileSystemRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20201228\Symplify\SmartFileSystem\SmartFileInfo;
final class UpdateFileNameByClassNameFileSystemRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20201228\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        $this->doTestFileInfo($smartFileInfo);
        $path = $this->originalTempFileInfo->getPath();
        $this->assertFileExists($path . '/DifferentClassName.php');
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Restoration\Rector\ClassLike\UpdateFileNameByClassNameFileSystemRector::class;
    }
}
