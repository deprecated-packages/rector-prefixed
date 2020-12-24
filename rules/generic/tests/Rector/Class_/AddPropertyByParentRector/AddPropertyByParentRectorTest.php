<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\Class_\AddPropertyByParentRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\Class_\AddPropertyByParentRector;
use _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\Class_\AddPropertyByParentRector\Source\SomeParentClassToAddDependencyBy;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\AddPropertyByParent;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class AddPropertyByParentRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\Class_\AddPropertyByParentRector::class => [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\Class_\AddPropertyByParentRector::PARENT_DEPENDENCIES => [new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\AddPropertyByParent(\_PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\Class_\AddPropertyByParentRector\Source\SomeParentClassToAddDependencyBy::class, 'SomeDependency')]]];
    }
}
