<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Transform\Tests\Rector\StaticCall\StaticCallToMethodCallRector;

use InvalidArgumentException;
use Iterator;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a2ac50786fa\Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class InvalidConfigurationTest extends \_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @var string[][]
     */
    private const CONFIGURATION = [['_PhpScoper0a2ac50786fa\\Nette\\Utils\\FileSystem', 'write', '_PhpScoper0a2ac50786fa\\Symplify\\SmartFileSystem\\SmartFileSystem', 'dumpFile']];
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper0a2ac50786fa\Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector::class => [\_PhpScoper0a2ac50786fa\Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector::STATIC_CALLS_TO_METHOD_CALLS => self::CONFIGURATION]];
    }
}
