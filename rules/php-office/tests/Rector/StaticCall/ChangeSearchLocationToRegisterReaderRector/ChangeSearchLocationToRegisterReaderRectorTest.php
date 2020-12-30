<?php

declare (strict_types=1);
namespace Rector\PHPOffice\Tests\Rector\StaticCall\ChangeSearchLocationToRegisterReaderRector;

use Iterator;
use Rector\PHPOffice\Rector\StaticCall\ChangeSearchLocationToRegisterReaderRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20201230\Symplify\SmartFileSystem\SmartFileInfo;
final class ChangeSearchLocationToRegisterReaderRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return \Rector\PHPOffice\Rector\StaticCall\ChangeSearchLocationToRegisterReaderRector::class;
    }
}
