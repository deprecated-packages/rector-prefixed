<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\Class_\ParentClassToTraitsRector;
use _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\AnotherParentObject;
use _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\ParentObject;
use _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\SecondTrait;
use _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\SomeTrait;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class ParentClassToTraitsRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\Class_\ParentClassToTraitsRector::class => [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\Class_\ParentClassToTraitsRector::PARENT_CLASS_TO_TRAITS => [\_PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\ParentObject::class => [\_PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\SomeTrait::class], \_PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\AnotherParentObject::class => [\_PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\SomeTrait::class, \_PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\SecondTrait::class]]]];
    }
}
