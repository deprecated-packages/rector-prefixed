<?php

declare (strict_types=1);
namespace Rector\Transform\Tests\Rector\Class_\ParentClassToTraitsRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Rector\Transform\Rector\Class_\ParentClassToTraitsRector;
use Rector\Transform\Tests\Rector\Class_\ParentClassToTraitsRector\Source\AnotherParentObject;
use Rector\Transform\Tests\Rector\Class_\ParentClassToTraitsRector\Source\ParentObject;
use Rector\Transform\Tests\Rector\Class_\ParentClassToTraitsRector\Source\SecondTrait;
use Rector\Transform\Tests\Rector\Class_\ParentClassToTraitsRector\Source\SomeTrait;
use Rector\Transform\ValueObject\ParentClassToTraits;
use RectorPrefix20210207\Symplify\SmartFileSystem\SmartFileInfo;
final class ParentClassToTraitsRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210207\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Transform\Rector\Class_\ParentClassToTraitsRector::class => [\Rector\Transform\Rector\Class_\ParentClassToTraitsRector::PARENT_CLASS_TO_TRAITS => [new \Rector\Transform\ValueObject\ParentClassToTraits(\Rector\Transform\Tests\Rector\Class_\ParentClassToTraitsRector\Source\ParentObject::class, [\Rector\Transform\Tests\Rector\Class_\ParentClassToTraitsRector\Source\SomeTrait::class]), new \Rector\Transform\ValueObject\ParentClassToTraits(\Rector\Transform\Tests\Rector\Class_\ParentClassToTraitsRector\Source\AnotherParentObject::class, [\Rector\Transform\Tests\Rector\Class_\ParentClassToTraitsRector\Source\SomeTrait::class, \Rector\Transform\Tests\Rector\Class_\ParentClassToTraitsRector\Source\SecondTrait::class])]]];
    }
}
