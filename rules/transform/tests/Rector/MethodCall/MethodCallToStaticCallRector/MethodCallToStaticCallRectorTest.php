<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Transform\Tests\Rector\MethodCall\MethodCallToStaticCallRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\MethodCall\MethodCallToStaticCallRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\MethodCallToStaticCall;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class MethodCallToStaticCallRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\MethodCall\MethodCallToStaticCallRector::class => [\_PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\MethodCall\MethodCallToStaticCallRector::METHOD_CALLS_TO_STATIC_CALLS => [new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\MethodCallToStaticCall(\_PhpScoper2a4e7ab1ecbc\Rector\Transform\Tests\Rector\MethodCall\MethodCallToStaticCallRector\AnotherDependency::class, 'process', 'StaticCaller', 'anotherMethod')]]];
    }
}
