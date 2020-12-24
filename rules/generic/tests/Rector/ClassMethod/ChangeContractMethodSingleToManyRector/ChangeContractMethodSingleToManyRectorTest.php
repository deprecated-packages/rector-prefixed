<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassMethod\ChangeContractMethodSingleToManyRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ChangeContractMethodSingleToManyRector;
use _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassMethod\ChangeContractMethodSingleToManyRector\Source\OneToManyInterface;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class ChangeContractMethodSingleToManyRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ChangeContractMethodSingleToManyRector::class => [\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ChangeContractMethodSingleToManyRector::OLD_TO_NEW_METHOD_BY_TYPE => [\_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassMethod\ChangeContractMethodSingleToManyRector\Source\OneToManyInterface::class => ['getNode' => 'getNodes']]]];
    }
}
