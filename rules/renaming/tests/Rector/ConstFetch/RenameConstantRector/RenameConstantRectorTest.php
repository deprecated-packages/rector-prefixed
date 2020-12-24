<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\ConstFetch\RenameConstantRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\ConstFetch\RenameConstantRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameConstantRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Renaming\Rector\ConstFetch\RenameConstantRector::class => [\_PhpScopere8e811afab72\Rector\Renaming\Rector\ConstFetch\RenameConstantRector::OLD_TO_NEW_CONSTANTS => ['MYSQL_ASSOC' => 'MYSQLI_ASSOC', 'OLD_CONSTANT' => 'NEW_CONSTANT']]];
    }
}
