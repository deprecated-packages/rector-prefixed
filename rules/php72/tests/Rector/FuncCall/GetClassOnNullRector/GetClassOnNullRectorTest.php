<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php72\Tests\Rector\FuncCall\GetClassOnNullRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Php72\Rector\FuncCall\GetClassOnNullRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class GetClassOnNullRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return \_PhpScopere8e811afab72\Rector\Php72\Rector\FuncCall\GetClassOnNullRector::class;
    }
}
