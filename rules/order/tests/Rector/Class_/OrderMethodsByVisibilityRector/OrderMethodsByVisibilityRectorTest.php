<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Order\Tests\Rector\Class_\OrderMethodsByVisibilityRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Order\Rector\Class_\OrderMethodsByVisibilityRector;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class OrderMethodsByVisibilityRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * Final + private method breaks :)
     * @requires PHP < 8.0
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
        return \_PhpScoperb75b35f52b74\Rector\Order\Rector\Class_\OrderMethodsByVisibilityRector::class;
    }
}
