<?php

declare (strict_types=1);
namespace Rector\DeadCode\Tests\Rector\MethodCall\RemoveDefaultArgumentValueRector;

use Iterator;
use Rector\DeadCode\Rector\MethodCall\RemoveDefaultArgumentValueRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210102\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveDefaultArgumentValueRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210102\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\DeadCode\Rector\MethodCall\RemoveDefaultArgumentValueRector::class;
    }
}
