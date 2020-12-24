<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NetteToSymfony\Tests\Rector\Interface_\DeleteFactoryInterfaceRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\NetteToSymfony\Rector\Interface_\DeleteFactoryInterfaceRector;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class DeleteFactoryInterfaceFileSystemRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
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
        return \_PhpScoper0a6b37af0871\Rector\NetteToSymfony\Rector\Interface_\DeleteFactoryInterfaceRector::class;
    }
}
