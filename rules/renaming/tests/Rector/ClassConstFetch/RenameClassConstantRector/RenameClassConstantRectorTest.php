<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector;
use _PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector\Source\DifferentClass;
use _PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector\Source\LocalFormEvents;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameClassConstant;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameClassConstantRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector::class => [\_PhpScopere8e811afab72\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector::CLASS_CONSTANT_RENAME => [new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameClassConstant(\_PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector\Source\LocalFormEvents::class, 'PRE_BIND', 'PRE_SUBMIT'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameClassConstant(\_PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector\Source\LocalFormEvents::class, 'BIND', 'SUBMIT'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameClassConstant(\_PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector\Source\LocalFormEvents::class, 'POST_BIND', 'POST_SUBMIT'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameClassConstant(\_PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector\Source\LocalFormEvents::class, 'OLD_CONSTANT', \_PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector\Source\DifferentClass::class . '::NEW_CONSTANT')]]];
    }
}
