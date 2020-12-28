<?php

declare (strict_types=1);
namespace Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector;

use Iterator;
use Rector\Generic\Rector\Class_\ParentClassToTraitsRector;
use Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\AnotherParentObject;
use Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\ParentObject;
use Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\SecondTrait;
use Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\SomeTrait;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20201228\Symplify\SmartFileSystem\SmartFileInfo;
final class ParentClassToTraitsRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20201228\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Generic\Rector\Class_\ParentClassToTraitsRector::class => [\Rector\Generic\Rector\Class_\ParentClassToTraitsRector::PARENT_CLASS_TO_TRAITS => [\Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\ParentObject::class => [\Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\SomeTrait::class], \Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\AnotherParentObject::class => [\Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\SomeTrait::class, \Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\SecondTrait::class]]]];
    }
}
