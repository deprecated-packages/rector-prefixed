<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Generic\Rector\Class_\ParentClassToTraitsRector;
use _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\AnotherParentObject;
use _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\ParentObject;
use _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\SecondTrait;
use _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\SomeTrait;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class ParentClassToTraitsRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\Class_\ParentClassToTraitsRector::class => [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\Class_\ParentClassToTraitsRector::PARENT_CLASS_TO_TRAITS => [\_PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\ParentObject::class => [\_PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\SomeTrait::class], \_PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\AnotherParentObject::class => [\_PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\SomeTrait::class, \_PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\Source\SecondTrait::class]]]];
    }
}
