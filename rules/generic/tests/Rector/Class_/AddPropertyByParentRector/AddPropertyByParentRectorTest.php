<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Class_\AddPropertyByParentRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Generic\Rector\Class_\AddPropertyByParentRector;
use _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Class_\AddPropertyByParentRector\Source\SomeParentClassToAddDependencyBy;
use _PhpScoper0a6b37af0871\Rector\Generic\ValueObject\AddPropertyByParent;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class AddPropertyByParentRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\Class_\AddPropertyByParentRector::class => [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\Class_\AddPropertyByParentRector::PARENT_DEPENDENCIES => [new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\AddPropertyByParent(\_PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Class_\AddPropertyByParentRector\Source\SomeParentClassToAddDependencyBy::class, 'SomeDependency')]]];
    }
}
