<?php

declare (strict_types=1);
namespace Rector\Php74\Tests\Rector\FuncCall\GetCalledClassToStaticClassRector;

use Iterator;
use Rector\Php74\Rector\FuncCall\GetCalledClassToStaticClassRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210220\Symplify\SmartFileSystem\SmartFileInfo;
final class GetCalledClassToStaticClassRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210220\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Php74\Rector\FuncCall\GetCalledClassToStaticClassRector::class;
    }
}
