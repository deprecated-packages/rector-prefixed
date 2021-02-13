<?php

declare (strict_types=1);
namespace Rector\DeadCode\Tests\Rector\If_\RemoveDeadInstanceOfRector;

use Iterator;
use Rector\DeadCode\Rector\If_\RemoveDeadInstanceOfRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210213\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveDeadInstanceOfRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210213\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\DeadCode\Rector\If_\RemoveDeadInstanceOfRector::class;
    }
}
