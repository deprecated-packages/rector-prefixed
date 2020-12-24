<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Transform\Tests\Rector\FuncCall\ArgumentFuncCallToMethodCallRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector;
use _PhpScopere8e811afab72\Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall;
use _PhpScopere8e811afab72\Rector\Transform\ValueObject\ArrayFuncCallToMethodCall;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class ArgumentFuncCallToMethodCallRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector::class => [\_PhpScopere8e811afab72\Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector::FUNCTIONS_TO_METHOD_CALLS => [new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('view', '_PhpScopere8e811afab72\\Illuminate\\Contracts\\View\\Factory', 'make'), new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('route', '_PhpScopere8e811afab72\\Illuminate\\Routing\\UrlGenerator', 'route'), new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('back', '_PhpScopere8e811afab72\\Illuminate\\Routing\\Redirector', 'back', 'back'), new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('broadcast', '_PhpScopere8e811afab72\\Illuminate\\Contracts\\Broadcasting\\Factory', 'event')], \_PhpScopere8e811afab72\Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector::ARRAY_FUNCTIONS_TO_METHOD_CALLS => [new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\ArrayFuncCallToMethodCall('config', '_PhpScopere8e811afab72\\Illuminate\\Contracts\\Config\\Repository', 'set', 'get'), new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\ArrayFuncCallToMethodCall('session', '_PhpScopere8e811afab72\\Illuminate\\Session\\SessionManager', 'put', 'get')]]];
    }
}
