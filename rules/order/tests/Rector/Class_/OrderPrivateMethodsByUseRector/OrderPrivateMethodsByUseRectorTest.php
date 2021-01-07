<?php

declare (strict_types=1);
namespace Rector\Order\Tests\Rector\Class_\OrderPrivateMethodsByUseRector;

use Iterator;
use Rector\Order\Rector\Class_\OrderPrivateMethodsByUseRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210107\Symplify\SmartFileSystem\SmartFileInfo;
final class OrderPrivateMethodsByUseRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210107\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Order\Rector\Class_\OrderPrivateMethodsByUseRector::class;
    }
}
