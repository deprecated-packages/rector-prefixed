<?php

declare (strict_types=1);
namespace Rector\CodeQuality\Tests\Rector\For_\ForToForeachRector;

use Iterator;
use Rector\CodeQuality\Rector\For_\ForToForeachRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210213\Symplify\SmartFileSystem\SmartFileInfo;
final class ForToForeachRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210213\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\CodeQuality\Rector\For_\ForToForeachRector::class;
    }
}
