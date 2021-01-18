<?php

declare (strict_types=1);
namespace Rector\Php72\Tests\Rector\FuncCall\IsObjectOnIncompleteClassRector;

use Iterator;
use Rector\Php72\Rector\FuncCall\IsObjectOnIncompleteClassRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210118\Symplify\SmartFileSystem\SmartFileInfo;
final class IsObjectOnIncompleteClassRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210118\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Php72\Rector\FuncCall\IsObjectOnIncompleteClassRector::class;
    }
}
