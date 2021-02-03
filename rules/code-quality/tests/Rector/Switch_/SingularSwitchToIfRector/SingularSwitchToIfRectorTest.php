<?php

declare (strict_types=1);
namespace Rector\CodeQuality\Tests\Rector\Switch_\SingularSwitchToIfRector;

use Iterator;
use Rector\CodeQuality\Rector\Switch_\SingularSwitchToIfRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210203\Symplify\SmartFileSystem\SmartFileInfo;
final class SingularSwitchToIfRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210203\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\CodeQuality\Rector\Switch_\SingularSwitchToIfRector::class;
    }
}
