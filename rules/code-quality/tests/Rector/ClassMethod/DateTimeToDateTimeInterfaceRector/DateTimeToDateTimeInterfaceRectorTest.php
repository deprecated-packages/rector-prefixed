<?php

declare (strict_types=1);
namespace Rector\CodeQuality\Tests\Rector\ClassMethod\DateTimeToDateTimeInterfaceRector;

use Iterator;
use Rector\CodeQuality\Rector\ClassMethod\DateTimeToDateTimeInterfaceRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210118\Symplify\SmartFileSystem\SmartFileInfo;
final class DateTimeToDateTimeInterfaceRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return \Rector\CodeQuality\Rector\ClassMethod\DateTimeToDateTimeInterfaceRector::class;
    }
}
