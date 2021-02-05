<?php

declare (strict_types=1);
namespace Rector\CodeQuality\Tests\Rector\Foreach_\UnusedForeachValueToArrayKeysRector;

use Iterator;
use Rector\CodeQuality\Rector\Foreach_\UnusedForeachValueToArrayKeysRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210205\Symplify\SmartFileSystem\SmartFileInfo;
final class UnusedForeachValueToArrayKeysRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210205\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\CodeQuality\Rector\Foreach_\UnusedForeachValueToArrayKeysRector::class;
    }
}
