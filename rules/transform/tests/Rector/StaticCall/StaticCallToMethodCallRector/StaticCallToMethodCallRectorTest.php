<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Transform\Tests\Rector\StaticCall\StaticCallToMethodCallRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector;
use _PhpScopere8e811afab72\Rector\Transform\ValueObject\StaticCallToMethodCall;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class StaticCallToMethodCallRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector::class => [\_PhpScopere8e811afab72\Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector::STATIC_CALLS_TO_METHOD_CALLS => [new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScopere8e811afab72\\Nette\\Utils\\FileSystem', 'write', '_PhpScopere8e811afab72\\Symplify\\SmartFileSystem\\SmartFileSystem', 'dumpFile'), new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScopere8e811afab72\\Illuminate\\Support\\Facades\\Response', '*', '_PhpScopere8e811afab72\\Illuminate\\Contracts\\Routing\\ResponseFactory', '*')]]];
    }
}
