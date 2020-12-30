<?php

declare (strict_types=1);
namespace Rector\DeadCode\Tests\Rector\Switch_\RemoveDuplicatedCaseInSwitchRector;

use Iterator;
use Rector\DeadCode\Rector\Switch_\RemoveDuplicatedCaseInSwitchRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20201230\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveDuplicatedCaseInSwitchRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20201230\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\DeadCode\Rector\Switch_\RemoveDuplicatedCaseInSwitchRector::class;
    }
}
