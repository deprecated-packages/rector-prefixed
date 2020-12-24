<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Class_\RemoveTraitRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Generic\Rector\Class_\RemoveTraitRector;
use _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Class_\RemoveTraitRector\Source\TraitToBeRemoved;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveTraitRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Generic\Rector\Class_\RemoveTraitRector::class => [\_PhpScopere8e811afab72\Rector\Generic\Rector\Class_\RemoveTraitRector::TRAITS_TO_REMOVE => [\_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Class_\RemoveTraitRector\Source\TraitToBeRemoved::class]]];
    }
}
