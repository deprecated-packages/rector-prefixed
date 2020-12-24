<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\MockeryToProphecy\Tests\Rector\StaticCall\MockeryToProphecyRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\MockeryToProphecy\Rector\StaticCall\MockeryCloseRemoveRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class MockeryToProphecyRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $file) : void
    {
        $this->doTestFileInfo($file);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScopere8e811afab72\Rector\MockeryToProphecy\Rector\StaticCall\MockeryCloseRemoveRector::class;
    }
}
