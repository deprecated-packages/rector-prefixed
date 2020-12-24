<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php80\Tests\Rector\ClassMethod\SetStateToStaticRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Php80\Rector\ClassMethod\SetStateToStaticRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class SetStateToStaticRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     * @requires PHP < 8.0
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
        return \_PhpScopere8e811afab72\Rector\Php80\Rector\ClassMethod\SetStateToStaticRector::class;
    }
}
