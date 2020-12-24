<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\FuncCall\FuncCallToStaticCallRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Generic\Rector\FuncCall\FuncCallToStaticCallRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Rector\Transform\ValueObject\FuncCallToStaticCall;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class FuncCallToStaticCallRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Generic\Rector\FuncCall\FuncCallToStaticCallRector::class => [\_PhpScopere8e811afab72\Rector\Generic\Rector\FuncCall\FuncCallToStaticCallRector::FUNC_CALLS_TO_STATIC_CALLS => [new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\FuncCallToStaticCall('view', 'SomeStaticClass', 'render'), new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\FuncCallToStaticCall('_PhpScopere8e811afab72\\SomeNamespaced\\view', 'AnotherStaticClass', 'render')]]];
    }
}
