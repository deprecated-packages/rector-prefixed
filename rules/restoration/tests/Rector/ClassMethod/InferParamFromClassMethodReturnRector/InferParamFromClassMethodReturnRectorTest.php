<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Restoration\Tests\Rector\ClassMethod\InferParamFromClassMethodReturnRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class InferParamFromClassMethodReturnRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
    protected function provideConfigFileInfo() : ?\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo
    {
        return new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/config/configured_rule.php');
    }
}
