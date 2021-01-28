<?php

declare (strict_types=1);
namespace Rector\Transform\Tests\Rector\StaticCall\StaticCallToMethodCallRector;

use InvalidArgumentException;
use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector;
use RectorPrefix20210128\Symplify\SmartFileSystem\SmartFileInfo;
final class InvalidConfigurationTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @var string[][]
     */
    private const CONFIGURATION = [['Nette\\Utils\\FileSystem', 'write', 'Symplify\\SmartFileSystem\\SmartFileSystem', 'dumpFile']];
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210128\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector::class => [\Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector::STATIC_CALLS_TO_METHOD_CALLS => self::CONFIGURATION]];
    }
}
