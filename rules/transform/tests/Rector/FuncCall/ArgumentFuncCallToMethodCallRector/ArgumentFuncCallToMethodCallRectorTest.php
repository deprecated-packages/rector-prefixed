<?php

declare (strict_types=1);
namespace Rector\Transform\Tests\Rector\FuncCall\ArgumentFuncCallToMethodCallRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector;
use Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall;
use Rector\Transform\ValueObject\ArrayFuncCallToMethodCall;
use RectorPrefix20210131\Symplify\SmartFileSystem\SmartFileInfo;
final class ArgumentFuncCallToMethodCallRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210131\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector::class => [\Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector::FUNCTIONS_TO_METHOD_CALLS => [new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('view', 'Illuminate\\Contracts\\View\\Factory', 'make'), new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('route', 'Illuminate\\Routing\\UrlGenerator', 'route'), new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('back', 'Illuminate\\Routing\\Redirector', 'back', 'back'), new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('broadcast', 'Illuminate\\Contracts\\Broadcasting\\Factory', 'event')], \Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector::ARRAY_FUNCTIONS_TO_METHOD_CALLS => [new \Rector\Transform\ValueObject\ArrayFuncCallToMethodCall('config', 'Illuminate\\Contracts\\Config\\Repository', 'set', 'get'), new \Rector\Transform\ValueObject\ArrayFuncCallToMethodCall('session', 'Illuminate\\Session\\SessionManager', 'put', 'get')]]];
    }
}
