<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php53\Tests\Rector\FuncCall\DirNameFileConstantToDirConstantRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Php53\Rector\FuncCall\DirNameFileConstantToDirConstantRector;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class DirNameFileConstantToDirConstantRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return \_PhpScoperb75b35f52b74\Rector\Php53\Rector\FuncCall\DirNameFileConstantToDirConstantRector::class;
    }
}
