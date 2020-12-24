<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php54\Tests\Rector\FuncCall\RemoveReferenceFromCallRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Php54\Rector\FuncCall\RemoveReferenceFromCallRector;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveReferenceFromCallRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfoWithoutAutoload($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoperb75b35f52b74\Rector\Php54\Rector\FuncCall\RemoveReferenceFromCallRector::class;
    }
}
