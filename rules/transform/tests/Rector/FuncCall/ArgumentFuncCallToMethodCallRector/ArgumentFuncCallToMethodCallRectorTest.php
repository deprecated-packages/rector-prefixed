<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Transform\Tests\Rector\FuncCall\ArgumentFuncCallToMethodCallRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector;
use _PhpScoperb75b35f52b74\Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall;
use _PhpScoperb75b35f52b74\Rector\Transform\ValueObject\ArrayFuncCallToMethodCall;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class ArgumentFuncCallToMethodCallRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoperb75b35f52b74\Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector::class => [\_PhpScoperb75b35f52b74\Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector::FUNCTIONS_TO_METHOD_CALLS => [new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('view', '_PhpScoperb75b35f52b74\\Illuminate\\Contracts\\View\\Factory', 'make'), new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('route', '_PhpScoperb75b35f52b74\\Illuminate\\Routing\\UrlGenerator', 'route'), new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('back', '_PhpScoperb75b35f52b74\\Illuminate\\Routing\\Redirector', 'back', 'back'), new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('broadcast', '_PhpScoperb75b35f52b74\\Illuminate\\Contracts\\Broadcasting\\Factory', 'event')], \_PhpScoperb75b35f52b74\Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector::ARRAY_FUNCTIONS_TO_METHOD_CALLS => [new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\ArrayFuncCallToMethodCall('config', '_PhpScoperb75b35f52b74\\Illuminate\\Contracts\\Config\\Repository', 'set', 'get'), new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\ArrayFuncCallToMethodCall('session', '_PhpScoperb75b35f52b74\\Illuminate\\Session\\SessionManager', 'put', 'get')]]];
    }
}
