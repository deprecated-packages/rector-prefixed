<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CakePHP\Tests\Rector\Namespace_\AppUsesStaticCallToUseStatementRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\CakePHP\Rector\Namespace_\AppUsesStaticCallToUseStatementRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class AppUsesStaticCallToUseStatementRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return \_PhpScopere8e811afab72\Rector\CakePHP\Rector\Namespace_\AppUsesStaticCallToUseStatementRector::class;
    }
}
