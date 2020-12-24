<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Transform\Tests\Rector\StaticCall\StaticCallToMethodCallRector;

use InvalidArgumentException;
use Iterator;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class InvalidConfigurationTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @var string[][]
     */
    private const CONFIGURATION = [['_PhpScoperb75b35f52b74\\Nette\\Utils\\FileSystem', 'write', '_PhpScoperb75b35f52b74\\Symplify\\SmartFileSystem\\SmartFileSystem', 'dumpFile']];
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoperb75b35f52b74\Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector::class => [\_PhpScoperb75b35f52b74\Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector::STATIC_CALLS_TO_METHOD_CALLS => self::CONFIGURATION]];
    }
}
