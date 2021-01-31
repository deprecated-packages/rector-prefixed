<?php

declare (strict_types=1);
namespace Rector\Php73\Tests\Rector\FuncCall\StringifyStrNeedlesRector;

use Iterator;
use Rector\Php73\Rector\FuncCall\StringifyStrNeedlesRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210131\Symplify\SmartFileSystem\SmartFileInfo;
final class StringifyStrNeedlesRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210131\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Php73\Rector\FuncCall\StringifyStrNeedlesRector::class;
    }
}
