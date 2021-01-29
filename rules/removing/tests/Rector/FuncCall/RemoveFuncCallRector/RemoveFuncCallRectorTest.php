<?php

declare (strict_types=1);
namespace Rector\Removing\Tests\Rector\FuncCall\RemoveFuncCallRector;

use Iterator;
use Rector\Removing\Rector\FuncCall\RemoveFuncCallRector;
use Rector\Removing\ValueObject\RemoveFuncCall;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use SplFileInfo;
use RectorPrefix20210129\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveFuncCallRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210129\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    /**
     * @return Iterator<SplFileInfo>
     */
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\Rector\Removing\Rector\FuncCall\RemoveFuncCallRector::class => [\Rector\Removing\Rector\FuncCall\RemoveFuncCallRector::REMOVE_FUNC_CALLS => [new \Rector\Removing\ValueObject\RemoveFuncCall('ini_get', [0 => ['y2k_compliance', 'safe_mode', 'magic_quotes_runtime']]), new \Rector\Removing\ValueObject\RemoveFuncCall('ini_set', [0 => ['y2k_compliance', 'safe_mode', 'magic_quotes_runtime']])]]];
    }
}
