<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Class_\AddInterfaceByTraitRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector;
use _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Class_\AddInterfaceByTraitRector\Source\SomeInterface;
use _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Class_\AddInterfaceByTraitRector\Source\SomeTrait;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class AddInterfaceByTraitRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::class => [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::INTERFACE_BY_TRAIT => [\_PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Class_\AddInterfaceByTraitRector\Source\SomeTrait::class => \_PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Class_\AddInterfaceByTraitRector\Source\SomeInterface::class]]];
    }
}
