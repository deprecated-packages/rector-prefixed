<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Transform\Tests\Rector\StaticCall\StaticCallToMethodCallRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\StaticCallToMethodCall;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class StaticCallToMethodCallRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector::class => [\_PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector::STATIC_CALLS_TO_METHOD_CALLS => [new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper2a4e7ab1ecbc\\Nette\\Utils\\FileSystem', 'write', '_PhpScoper2a4e7ab1ecbc\\Symplify\\SmartFileSystem\\SmartFileSystem', 'dumpFile'), new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper2a4e7ab1ecbc\\Illuminate\\Support\\Facades\\Response', '*', '_PhpScoper2a4e7ab1ecbc\\Illuminate\\Contracts\\Routing\\ResponseFactory', '*')]]];
    }
}
