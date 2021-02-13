<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Tests\Rector\ClassMethod\UnSpreadOperatorRector;

use Iterator;
use Rector\CodingStyle\Rector\ClassMethod\UnSpreadOperatorRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210213\Symplify\SmartFileSystem\SmartFileInfo;
final class UnSpreadOperatorRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return \Rector\CodingStyle\Rector\ClassMethod\UnSpreadOperatorRector::class;
    }
}
