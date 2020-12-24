<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddArrayParamDocTypeRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Rector\ClassMethod\AddArrayParamDocTypeRector;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class AddArrayParamDocTypeRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Rector\ClassMethod\AddArrayParamDocTypeRector::class;
    }
}
