<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassMethod\AddMethodParentCallRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector;
use _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassMethod\AddMethodParentCallRector\Source\ParentClassWithNewConstructor;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class AddMethodParentCallRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::class => [\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::METHODS_BY_PARENT_TYPES => [\_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassMethod\AddMethodParentCallRector\Source\ParentClassWithNewConstructor::class => '__construct']]];
    }
}
