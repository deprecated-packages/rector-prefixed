<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php70\Tests\Rector\Assign\ListSwapArrayOrderRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Php70\Rector\Assign\ListSwapArrayOrderRector;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class ListSwapArrayOrderRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoperb75b35f52b74\Rector\Php70\Rector\Assign\ListSwapArrayOrderRector::class;
    }
}
