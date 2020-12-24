<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Transform\Tests\Rector\StaticCall\StaticCallToMethodCallRector;

use InvalidArgumentException;
use Iterator;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class InvalidConfigurationTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @var string[][]
     */
    private const CONFIGURATION = [['_PhpScoper0a6b37af0871\\Nette\\Utils\\FileSystem', 'write', '_PhpScoper0a6b37af0871\\Symplify\\SmartFileSystem\\SmartFileSystem', 'dumpFile']];
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->expectException(\InvalidArgumentException::class);
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
        return [\_PhpScoper0a6b37af0871\Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector::class => [\_PhpScoper0a6b37af0871\Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector::STATIC_CALLS_TO_METHOD_CALLS => self::CONFIGURATION]];
    }
}
