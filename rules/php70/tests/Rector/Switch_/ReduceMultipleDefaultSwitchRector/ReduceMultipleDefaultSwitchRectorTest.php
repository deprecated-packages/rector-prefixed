<?php

declare (strict_types=1);
namespace Rector\Php70\Tests\Rector\Switch_\ReduceMultipleDefaultSwitchRector;

use Iterator;
use Rector\Php70\Rector\Switch_\ReduceMultipleDefaultSwitchRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210111\Symplify\SmartFileSystem\SmartFileInfo;
final class ReduceMultipleDefaultSwitchRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210111\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfoWithoutAutoload($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Php70\Rector\Switch_\ReduceMultipleDefaultSwitchRector::class;
    }
}
