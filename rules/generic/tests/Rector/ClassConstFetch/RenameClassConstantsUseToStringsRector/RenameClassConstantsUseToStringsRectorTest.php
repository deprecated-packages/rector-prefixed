<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassConstFetch\RenameClassConstantsUseToStringsRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Generic\Rector\ClassConstFetch\RenameClassConstantsUseToStringsRector;
use _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassConstFetch\RenameClassConstantsUseToStringsRector\Source\OldClassWithConstants;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameClassConstantsUseToStringsRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassConstFetch\RenameClassConstantsUseToStringsRector::class => [\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassConstFetch\RenameClassConstantsUseToStringsRector::OLD_CONSTANTS_TO_NEW_VALUES_BY_TYPE => [\_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassConstFetch\RenameClassConstantsUseToStringsRector\Source\OldClassWithConstants::class => ['DEVELOPMENT' => 'development', 'PRODUCTION' => 'production']]]];
    }
}
