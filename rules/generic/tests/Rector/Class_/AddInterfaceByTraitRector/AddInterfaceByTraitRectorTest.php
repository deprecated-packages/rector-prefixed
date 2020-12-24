<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Class_\AddInterfaceByTraitRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector;
use _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Class_\AddInterfaceByTraitRector\Source\SomeInterface;
use _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Class_\AddInterfaceByTraitRector\Source\SomeTrait;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class AddInterfaceByTraitRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScopere8e811afab72\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::class => [\_PhpScopere8e811afab72\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::INTERFACE_BY_TRAIT => [\_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Class_\AddInterfaceByTraitRector\Source\SomeTrait::class => \_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Class_\AddInterfaceByTraitRector\Source\SomeInterface::class]]];
    }
}
