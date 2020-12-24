<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Generic\Rector\Class_\ParentClassToTraitsRector;
use _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\AnotherParentObject;
use _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\ParentObject;
use _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\SecondTrait;
use _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\SomeTrait;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class ParentClassToTraitsRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Generic\Rector\Class_\ParentClassToTraitsRector::class => [\_PhpScopere8e811afab72\Rector\Generic\Rector\Class_\ParentClassToTraitsRector::PARENT_CLASS_TO_TRAITS => [\_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\ParentObject::class => [\_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\SomeTrait::class], \_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\AnotherParentObject::class => [\_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\SomeTrait::class, \_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\SecondTrait::class]]]];
    }
}
