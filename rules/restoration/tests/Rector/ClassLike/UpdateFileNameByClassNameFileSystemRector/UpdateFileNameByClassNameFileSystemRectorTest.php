<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Restoration\Tests\Rector\ClassLike\UpdateFileNameByClassNameFileSystemRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Restoration\Rector\ClassLike\UpdateFileNameByClassNameFileSystemRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class UpdateFileNameByClassNameFileSystemRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
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
        return \_PhpScopere8e811afab72\Rector\Restoration\Rector\ClassLike\UpdateFileNameByClassNameFileSystemRector::class;
    }
}
