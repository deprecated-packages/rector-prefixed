<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteToSymfony\Tests\Rector\Interface_\DeleteFactoryInterfaceRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\NetteToSymfony\Rector\Interface_\DeleteFactoryInterfaceRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class DeleteFactoryInterfaceFileSystemRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        $this->doTestFileInfo($smartFileInfo);
        $this->assertFileWasRemoved($this->originalTempFileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScopere8e811afab72\Rector\NetteToSymfony\Rector\Interface_\DeleteFactoryInterfaceRector::class;
    }
}
