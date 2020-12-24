<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Class_\RemoveParentRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Generic\Rector\Class_\RemoveParentRector;
use _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Class_\RemoveParentRector\Source\ParentTypeToBeRemoved;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveParentRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\_PhpScopere8e811afab72\Rector\Generic\Rector\Class_\RemoveParentRector::class => [\_PhpScopere8e811afab72\Rector\Generic\Rector\Class_\RemoveParentRector::PARENT_TYPES_TO_REMOVE => [\_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Class_\RemoveParentRector\Source\ParentTypeToBeRemoved::class]]];
    }
}
