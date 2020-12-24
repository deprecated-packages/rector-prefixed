<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Transform\Tests\Rector\MethodCall\MethodCallToStaticCallRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Rector\Transform\Rector\MethodCall\MethodCallToStaticCallRector;
use _PhpScopere8e811afab72\Rector\Transform\ValueObject\MethodCallToStaticCall;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class MethodCallToStaticCallRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Transform\Rector\MethodCall\MethodCallToStaticCallRector::class => [\_PhpScopere8e811afab72\Rector\Transform\Rector\MethodCall\MethodCallToStaticCallRector::METHOD_CALLS_TO_STATIC_CALLS => [new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\MethodCallToStaticCall(\_PhpScopere8e811afab72\Rector\Transform\Tests\Rector\MethodCall\MethodCallToStaticCallRector\AnotherDependency::class, 'process', 'StaticCaller', 'anotherMethod')]]];
    }
}
