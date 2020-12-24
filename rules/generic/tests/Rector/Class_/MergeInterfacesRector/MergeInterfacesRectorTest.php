<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Class_\MergeInterfacesRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Generic\Rector\Class_\MergeInterfacesRector;
use _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Class_\MergeInterfacesRector\Source\SomeInterface;
use _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Class_\MergeInterfacesRector\Source\SomeOldInterface;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class MergeInterfacesRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Generic\Rector\Class_\MergeInterfacesRector::class => [\_PhpScopere8e811afab72\Rector\Generic\Rector\Class_\MergeInterfacesRector::OLD_TO_NEW_INTERFACES => [\_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Class_\MergeInterfacesRector\Source\SomeOldInterface::class => \_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Class_\MergeInterfacesRector\Source\SomeInterface::class]]];
    }
}
