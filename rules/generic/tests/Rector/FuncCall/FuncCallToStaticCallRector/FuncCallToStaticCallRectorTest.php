<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\FuncCall\FuncCallToStaticCallRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Generic\Rector\FuncCall\FuncCallToStaticCallRector;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Rector\Transform\ValueObject\FuncCallToStaticCall;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class FuncCallToStaticCallRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\FuncCall\FuncCallToStaticCallRector::class => [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\FuncCall\FuncCallToStaticCallRector::FUNC_CALLS_TO_STATIC_CALLS => [new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\FuncCallToStaticCall('view', 'SomeStaticClass', 'render'), new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\FuncCallToStaticCall('_PhpScoper0a6b37af0871\\SomeNamespaced\\view', 'AnotherStaticClass', 'render')]]];
    }
}
