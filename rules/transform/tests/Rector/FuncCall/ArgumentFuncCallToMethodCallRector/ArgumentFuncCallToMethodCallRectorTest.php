<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Transform\Tests\Rector\FuncCall\ArgumentFuncCallToMethodCallRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall;
use _PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\ArrayFuncCallToMethodCall;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class ArgumentFuncCallToMethodCallRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector::class => [\_PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector::FUNCTIONS_TO_METHOD_CALLS => [new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('view', '_PhpScoper2a4e7ab1ecbc\\Illuminate\\Contracts\\View\\Factory', 'make'), new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('route', '_PhpScoper2a4e7ab1ecbc\\Illuminate\\Routing\\UrlGenerator', 'route'), new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('back', '_PhpScoper2a4e7ab1ecbc\\Illuminate\\Routing\\Redirector', 'back', 'back'), new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('broadcast', '_PhpScoper2a4e7ab1ecbc\\Illuminate\\Contracts\\Broadcasting\\Factory', 'event')], \_PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector::ARRAY_FUNCTIONS_TO_METHOD_CALLS => [new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\ArrayFuncCallToMethodCall('config', '_PhpScoper2a4e7ab1ecbc\\Illuminate\\Contracts\\Config\\Repository', 'set', 'get'), new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\ArrayFuncCallToMethodCall('session', '_PhpScoper2a4e7ab1ecbc\\Illuminate\\Session\\SessionManager', 'put', 'get')]]];
    }
}
