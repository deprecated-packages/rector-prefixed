<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php53\Tests\Rector\Variable\ReplaceHttpServerVarsByServerRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Php53\Rector\Variable\ReplaceHttpServerVarsByServerRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use SplFileInfo;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class ReplaceHttpServerVarsByServerRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    /**
     * @return Iterator<SplFileInfo>
     */
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScopere8e811afab72\Rector\Php53\Rector\Variable\ReplaceHttpServerVarsByServerRector::class;
    }
}
