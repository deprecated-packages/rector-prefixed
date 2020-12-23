<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\Class_\AddInterfaceByTraitRector;

use Iterator;
use _PhpScoper0a2ac50786fa\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector;
use _PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\Class_\AddInterfaceByTraitRector\Source\SomeInterface;
use _PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\Class_\AddInterfaceByTraitRector\Source\SomeTrait;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class AddInterfaceByTraitRectorTest extends \_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a2ac50786fa\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::class => [\_PhpScoper0a2ac50786fa\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::INTERFACE_BY_TRAIT => [\_PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\Class_\AddInterfaceByTraitRector\Source\SomeTrait::class => \_PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\Class_\AddInterfaceByTraitRector\Source\SomeInterface::class]]];
    }
}
