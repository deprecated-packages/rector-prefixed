<?php

declare (strict_types=1);
namespace Rector\Symfony\Tests\Rector\Return_\SimpleFunctionAndFilterRector;

use Iterator;
use Rector\Symfony\Rector\Return_\SimpleFunctionAndFilterRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210224\Symplify\SmartFileSystem\SmartFileInfo;
final class SimpleFunctionAndFilterRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210224\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Symfony\Rector\Return_\SimpleFunctionAndFilterRector::class;
    }
}
