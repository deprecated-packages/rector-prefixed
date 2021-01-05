<?php

declare (strict_types=1);
namespace Rector\Laravel\Tests\Rector\FuncCall\HelperFuncCallToFacadeClassRector;

use Iterator;
use Rector\Laravel\Rector\FuncCall\HelperFuncCallToFacadeClassRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210105\Symplify\SmartFileSystem\SmartFileInfo;
final class HelperFuncCallToFacadeClassRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210105\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Laravel\Rector\FuncCall\HelperFuncCallToFacadeClassRector::class;
    }
}
