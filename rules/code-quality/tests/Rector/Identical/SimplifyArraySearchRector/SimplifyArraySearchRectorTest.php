<?php

declare (strict_types=1);
namespace Rector\CodeQuality\Tests\Rector\Identical\SimplifyArraySearchRector;

use Iterator;
use Rector\CodeQuality\Rector\Identical\SimplifyArraySearchRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210221\Symplify\SmartFileSystem\SmartFileInfo;
final class SimplifyArraySearchRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210221\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\CodeQuality\Rector\Identical\SimplifyArraySearchRector::class;
    }
}
