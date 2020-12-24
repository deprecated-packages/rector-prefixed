<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\Class_\RemoveInterfacesRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\Class_\RemoveInterfacesRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\Class_\RemoveInterfacesRector\Source\SomeInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveInterfacesRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\Class_\RemoveInterfacesRector::class => [\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\Class_\RemoveInterfacesRector::INTERFACES_TO_REMOVE => [\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\Class_\RemoveInterfacesRector\Source\SomeInterface::class]]];
    }
}
