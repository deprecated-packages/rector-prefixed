<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Class_\RemoveInterfacesRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Generic\Rector\Class_\RemoveInterfacesRector;
use _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Class_\RemoveInterfacesRector\Source\SomeInterface;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveInterfacesRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\Class_\RemoveInterfacesRector::class => [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\Class_\RemoveInterfacesRector::INTERFACES_TO_REMOVE => [\_PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Class_\RemoveInterfacesRector\Source\SomeInterface::class]]];
    }
}
