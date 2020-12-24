<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DowngradePhp71\Tests\Rector\String_\DowngradeNegativeStringOffsetToStrlenRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\DowngradePhp71\Rector\String_\DowngradeNegativeStringOffsetToStrlenRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class DowngradeNegativeStringOffsetToStrlenRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @requires PHP 7.1
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
        return \_PhpScopere8e811afab72\Rector\DowngradePhp71\Rector\String_\DowngradeNegativeStringOffsetToStrlenRector::class;
    }
}
