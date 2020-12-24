<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php80\Tests\Rector\FuncCall\TokenGetAllToObjectRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Php80\Rector\FuncCall\TokenGetAllToObjectRector;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class TokenGetAllToObjectRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return \_PhpScoperb75b35f52b74\Rector\Php80\Rector\FuncCall\TokenGetAllToObjectRector::class;
    }
}
