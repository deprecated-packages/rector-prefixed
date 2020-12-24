<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php52\Tests\Rector\Switch_\ContinueToBreakInSwitchRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Php52\Rector\Switch_\ContinueToBreakInSwitchRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class ContinueToBreakInSwitchRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfoWithoutAutoload($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScopere8e811afab72\Rector\Php52\Rector\Switch_\ContinueToBreakInSwitchRector::class;
    }
}
