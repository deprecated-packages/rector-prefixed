<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Laravel\Tests\Rector\StaticCall\Redirect301ToPermanentRedirectRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Laravel\Rector\StaticCall\Redirect301ToPermanentRedirectRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class Redirect301ToPermanentRedirectRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return \_PhpScopere8e811afab72\Rector\Laravel\Rector\StaticCall\Redirect301ToPermanentRedirectRector::class;
    }
}
