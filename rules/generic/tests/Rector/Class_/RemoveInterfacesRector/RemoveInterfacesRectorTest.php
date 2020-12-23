<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\Class_\RemoveInterfacesRector;

use Iterator;
use _PhpScoper0a2ac50786fa\Rector\Generic\Rector\Class_\RemoveInterfacesRector;
use _PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\Class_\RemoveInterfacesRector\Source\SomeInterface;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveInterfacesRectorTest extends \_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper0a2ac50786fa\Rector\Generic\Rector\Class_\RemoveInterfacesRector::class => [\_PhpScoper0a2ac50786fa\Rector\Generic\Rector\Class_\RemoveInterfacesRector::INTERFACES_TO_REMOVE => [\_PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\Class_\RemoveInterfacesRector\Source\SomeInterface::class]]];
    }
}
