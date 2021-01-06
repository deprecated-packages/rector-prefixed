<?php

declare (strict_types=1);
namespace Rector\NetteToSymfony\Tests\Rector\Interface_\DeleteFactoryInterfaceRector;

use Iterator;
use Rector\NetteToSymfony\Rector\Interface_\DeleteFactoryInterfaceRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210106\Symplify\SmartFileSystem\SmartFileInfo;
final class DeleteFactoryInterfaceFileSystemRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210106\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
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
        return \Rector\NetteToSymfony\Rector\Interface_\DeleteFactoryInterfaceRector::class;
    }
}
