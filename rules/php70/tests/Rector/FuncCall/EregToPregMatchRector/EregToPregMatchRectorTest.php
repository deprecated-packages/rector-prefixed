<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php70\Tests\Rector\FuncCall\EregToPregMatchRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Php70\Rector\FuncCall\EregToPregMatchRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class EregToPregMatchRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
    protected function getRectorClass() : string
    {
        return \_PhpScopere8e811afab72\Rector\Php70\Rector\FuncCall\EregToPregMatchRector::class;
    }
}
