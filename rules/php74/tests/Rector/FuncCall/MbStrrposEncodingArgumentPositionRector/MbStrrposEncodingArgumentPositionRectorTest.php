<?php

declare (strict_types=1);
namespace Rector\Php74\Tests\Rector\FuncCall\MbStrrposEncodingArgumentPositionRector;

use Iterator;
use Rector\Php74\Rector\FuncCall\MbStrrposEncodingArgumentPositionRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210114\Symplify\SmartFileSystem\SmartFileInfo;
final class MbStrrposEncodingArgumentPositionRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210114\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Php74\Rector\FuncCall\MbStrrposEncodingArgumentPositionRector::class;
    }
}
