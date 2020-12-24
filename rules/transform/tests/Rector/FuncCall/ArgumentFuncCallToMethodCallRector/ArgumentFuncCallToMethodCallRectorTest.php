<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Transform\Tests\Rector\FuncCall\ArgumentFuncCallToMethodCallRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector;
use _PhpScoper0a6b37af0871\Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall;
use _PhpScoper0a6b37af0871\Rector\Transform\ValueObject\ArrayFuncCallToMethodCall;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class ArgumentFuncCallToMethodCallRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper0a6b37af0871\Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector::class => [\_PhpScoper0a6b37af0871\Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector::FUNCTIONS_TO_METHOD_CALLS => [new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('view', '_PhpScoper0a6b37af0871\\Illuminate\\Contracts\\View\\Factory', 'make'), new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('route', '_PhpScoper0a6b37af0871\\Illuminate\\Routing\\UrlGenerator', 'route'), new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('back', '_PhpScoper0a6b37af0871\\Illuminate\\Routing\\Redirector', 'back', 'back'), new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('broadcast', '_PhpScoper0a6b37af0871\\Illuminate\\Contracts\\Broadcasting\\Factory', 'event')], \_PhpScoper0a6b37af0871\Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector::ARRAY_FUNCTIONS_TO_METHOD_CALLS => [new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\ArrayFuncCallToMethodCall('config', '_PhpScoper0a6b37af0871\\Illuminate\\Contracts\\Config\\Repository', 'set', 'get'), new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\ArrayFuncCallToMethodCall('session', '_PhpScoper0a6b37af0871\\Illuminate\\Session\\SessionManager', 'put', 'get')]]];
    }
}
