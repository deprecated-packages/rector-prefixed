<?php

declare (strict_types=1);
namespace Rector\CodeQuality\Tests\Rector\If_\SimplifyIfReturnBoolRector;

use Iterator;
use Rector\CodeQuality\Rector\If_\SimplifyIfReturnBoolRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210128\Symplify\SmartFileSystem\SmartFileInfo;
final class SimplifyIfReturnBoolRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210128\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\CodeQuality\Rector\If_\SimplifyIfReturnBoolRector::class;
    }
}
