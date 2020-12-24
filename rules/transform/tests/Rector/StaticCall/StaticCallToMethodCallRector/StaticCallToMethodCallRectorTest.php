<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Transform\Tests\Rector\StaticCall\StaticCallToMethodCallRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector;
use _PhpScoper0a6b37af0871\Rector\Transform\ValueObject\StaticCallToMethodCall;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class StaticCallToMethodCallRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a6b37af0871\Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector::class => [\_PhpScoper0a6b37af0871\Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector::STATIC_CALLS_TO_METHOD_CALLS => [new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper0a6b37af0871\\Nette\\Utils\\FileSystem', 'write', '_PhpScoper0a6b37af0871\\Symplify\\SmartFileSystem\\SmartFileSystem', 'dumpFile'), new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper0a6b37af0871\\Illuminate\\Support\\Facades\\Response', '*', '_PhpScoper0a6b37af0871\\Illuminate\\Contracts\\Routing\\ResponseFactory', '*')]]];
    }
}
