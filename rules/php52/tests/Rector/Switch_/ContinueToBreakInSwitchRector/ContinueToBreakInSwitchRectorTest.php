<?php

declare (strict_types=1);
namespace Rector\Php52\Tests\Rector\Switch_\ContinueToBreakInSwitchRector;

use Iterator;
use Rector\Php52\Rector\Switch_\ContinueToBreakInSwitchRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210131\Symplify\SmartFileSystem\SmartFileInfo;
final class ContinueToBreakInSwitchRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210131\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfoWithoutAutoload($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Php52\Rector\Switch_\ContinueToBreakInSwitchRector::class;
    }
}
