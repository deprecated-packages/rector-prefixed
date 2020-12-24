<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Transform\Tests\Rector\StaticCall\StaticCallToFuncCallRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector;
use _PhpScopere8e811afab72\Rector\Transform\Tests\Rector\StaticCall\StaticCallToFuncCallRector\Source\SomeOldStaticClass;
use _PhpScopere8e811afab72\Rector\Transform\ValueObject\StaticCallToFuncCall;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class StaticCallToFuncCallRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector::class => [\_PhpScopere8e811afab72\Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector::STATIC_CALLS_TO_FUNCTIONS => [new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\StaticCallToFuncCall(\_PhpScopere8e811afab72\Rector\Transform\Tests\Rector\StaticCall\StaticCallToFuncCallRector\Source\SomeOldStaticClass::class, 'render', 'view')]]];
    }
}
