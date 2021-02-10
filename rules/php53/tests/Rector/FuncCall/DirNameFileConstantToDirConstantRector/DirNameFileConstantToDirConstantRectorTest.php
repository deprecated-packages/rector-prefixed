<?php

declare (strict_types=1);
namespace Rector\Php53\Tests\Rector\FuncCall\DirNameFileConstantToDirConstantRector;

use Iterator;
use Rector\Php53\Rector\FuncCall\DirNameFileConstantToDirConstantRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210210\Symplify\SmartFileSystem\SmartFileInfo;
final class DirNameFileConstantToDirConstantRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210210\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Php53\Rector\FuncCall\DirNameFileConstantToDirConstantRector::class;
    }
}
