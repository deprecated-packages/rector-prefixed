<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PhpDeglobalize\Tests\Rector\ClassMethod\ChangeGlobalVariablesToPropertiesRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\PhpDeglobalize\Rector\ClassMethod\ChangeGlobalVariablesToPropertiesRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class ChangeGlobalVariablesToPropertiesRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScopere8e811afab72\Rector\PhpDeglobalize\Rector\ClassMethod\ChangeGlobalVariablesToPropertiesRector::class;
    }
}
