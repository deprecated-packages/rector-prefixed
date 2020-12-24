<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Class_\AddPropertyByParentRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Generic\Rector\Class_\AddPropertyByParentRector;
use _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Class_\AddPropertyByParentRector\Source\SomeParentClassToAddDependencyBy;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\AddPropertyByParent;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class AddPropertyByParentRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Generic\Rector\Class_\AddPropertyByParentRector::class => [\_PhpScopere8e811afab72\Rector\Generic\Rector\Class_\AddPropertyByParentRector::PARENT_DEPENDENCIES => [new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\AddPropertyByParent(\_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Class_\AddPropertyByParentRector\Source\SomeParentClassToAddDependencyBy::class, 'SomeDependency')]]];
    }
}
