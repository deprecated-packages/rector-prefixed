<?php

declare (strict_types=1);
namespace Rector\Php70\Tests\Rector\List_\EmptyListRector;

use Iterator;
use Rector\Php70\Rector\List_\EmptyListRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210301\Symplify\SmartFileSystem\SmartFileInfo;
final class EmptyListRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210301\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Php70\Rector\List_\EmptyListRector::class;
    }
}
