<?php

declare (strict_types=1);
namespace Rector\DeadCode\Tests\Rector\Assign\RemoveDoubleAssignRector;

use Iterator;
use Rector\DeadCode\Rector\Assign\RemoveDoubleAssignRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210216\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveDoubleAssignRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210216\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\DeadCode\Rector\Assign\RemoveDoubleAssignRector::class;
    }
}
