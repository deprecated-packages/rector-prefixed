<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Transform\Tests\Rector\StaticCall\StaticCallToMethodCallRector;

use Iterator;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a2ac50786fa\Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector;
use _PhpScoper0a2ac50786fa\Rector\Transform\ValueObject\StaticCallToMethodCall;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class StaticCallToMethodCallRectorTest extends \_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a2ac50786fa\Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector::class => [\_PhpScoper0a2ac50786fa\Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector::STATIC_CALLS_TO_METHOD_CALLS => [new \_PhpScoper0a2ac50786fa\Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper0a2ac50786fa\\Nette\\Utils\\FileSystem', 'write', '_PhpScoper0a2ac50786fa\\Symplify\\SmartFileSystem\\SmartFileSystem', 'dumpFile'), new \_PhpScoper0a2ac50786fa\Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper0a2ac50786fa\\Illuminate\\Support\\Facades\\Response', '*', '_PhpScoper0a2ac50786fa\\Illuminate\\Contracts\\Routing\\ResponseFactory', '*')]]];
    }
}
