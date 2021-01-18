<?php

declare (strict_types=1);
namespace Rector\DeadCode\Tests\Rector\Return_\RemoveDeadConditionAboveReturnRector;

use Iterator;
use Rector\DeadCode\Rector\Return_\RemoveDeadConditionAboveReturnRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210118\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveDeadConditionAboveReturnRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210118\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\DeadCode\Rector\Return_\RemoveDeadConditionAboveReturnRector::class;
    }
}
