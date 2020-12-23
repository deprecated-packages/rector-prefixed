<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Transform\Tests\Rector\FuncCall\ArgumentFuncCallToMethodCallRector;

use Iterator;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a2ac50786fa\Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector;
use _PhpScoper0a2ac50786fa\Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall;
use _PhpScoper0a2ac50786fa\Rector\Transform\ValueObject\ArrayFuncCallToMethodCall;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class ArgumentFuncCallToMethodCallRectorTest extends \_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper0a2ac50786fa\Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector::class => [\_PhpScoper0a2ac50786fa\Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector::FUNCTIONS_TO_METHOD_CALLS => [new \_PhpScoper0a2ac50786fa\Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('view', '_PhpScoper0a2ac50786fa\\Illuminate\\Contracts\\View\\Factory', 'make'), new \_PhpScoper0a2ac50786fa\Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('route', '_PhpScoper0a2ac50786fa\\Illuminate\\Routing\\UrlGenerator', 'route'), new \_PhpScoper0a2ac50786fa\Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('back', '_PhpScoper0a2ac50786fa\\Illuminate\\Routing\\Redirector', 'back', 'back'), new \_PhpScoper0a2ac50786fa\Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('broadcast', '_PhpScoper0a2ac50786fa\\Illuminate\\Contracts\\Broadcasting\\Factory', 'event')], \_PhpScoper0a2ac50786fa\Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector::ARRAY_FUNCTIONS_TO_METHOD_CALLS => [new \_PhpScoper0a2ac50786fa\Rector\Transform\ValueObject\ArrayFuncCallToMethodCall('config', '_PhpScoper0a2ac50786fa\\Illuminate\\Contracts\\Config\\Repository', 'set', 'get'), new \_PhpScoper0a2ac50786fa\Rector\Transform\ValueObject\ArrayFuncCallToMethodCall('session', '_PhpScoper0a2ac50786fa\\Illuminate\\Session\\SessionManager', 'put', 'get')]]];
    }
}
