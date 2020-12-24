<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteToSymfony\Tests\Rector\Interface_\DeleteFactoryInterfaceRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\NetteToSymfony\Rector\Interface_\DeleteFactoryInterfaceRector;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class DeleteFactoryInterfaceFileSystemRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        $this->doTestFileInfo($smartFileInfo);
        $this->assertFileWasRemoved($this->originalTempFileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoperb75b35f52b74\Rector\NetteToSymfony\Rector\Interface_\DeleteFactoryInterfaceRector::class;
    }
}
