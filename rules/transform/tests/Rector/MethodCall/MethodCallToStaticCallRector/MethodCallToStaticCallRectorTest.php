<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Transform\Tests\Rector\MethodCall\MethodCallToStaticCallRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Rector\Transform\Rector\MethodCall\MethodCallToStaticCallRector;
use _PhpScoper0a6b37af0871\Rector\Transform\ValueObject\MethodCallToStaticCall;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class MethodCallToStaticCallRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a6b37af0871\Rector\Transform\Rector\MethodCall\MethodCallToStaticCallRector::class => [\_PhpScoper0a6b37af0871\Rector\Transform\Rector\MethodCall\MethodCallToStaticCallRector::METHOD_CALLS_TO_STATIC_CALLS => [new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\MethodCallToStaticCall(\_PhpScoper0a6b37af0871\Rector\Transform\Tests\Rector\MethodCall\MethodCallToStaticCallRector\AnotherDependency::class, 'process', 'StaticCaller', 'anotherMethod')]]];
    }
}
