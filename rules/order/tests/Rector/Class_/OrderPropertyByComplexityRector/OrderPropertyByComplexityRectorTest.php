<?php

declare (strict_types=1);
namespace Rector\Order\Tests\Rector\Class_\OrderPropertyByComplexityRector;

use Iterator;
use Rector\Order\Rector\Class_\OrderPropertyByComplexityRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210121\Symplify\SmartFileSystem\SmartFileInfo;
final class OrderPropertyByComplexityRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210121\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Order\Rector\Class_\OrderPropertyByComplexityRector::class;
    }
}
