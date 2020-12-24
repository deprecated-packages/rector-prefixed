<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\Class_\AddInterfaceByTraitRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector;
use _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\Class_\AddInterfaceByTraitRector\Source\SomeInterface;
use _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\Class_\AddInterfaceByTraitRector\Source\SomeTrait;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class AddInterfaceByTraitRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::class => [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::INTERFACE_BY_TRAIT => [\_PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\Class_\AddInterfaceByTraitRector\Source\SomeTrait::class => \_PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\Class_\AddInterfaceByTraitRector\Source\SomeInterface::class]]];
    }
}
