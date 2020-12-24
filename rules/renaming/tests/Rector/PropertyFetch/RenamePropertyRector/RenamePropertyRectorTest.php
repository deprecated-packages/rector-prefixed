<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\PropertyFetch\RenamePropertyRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\PropertyFetch\RenamePropertyRector\Source\ClassWithProperties;
use _PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameProperty;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class RenamePropertyRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::class => [\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::RENAMED_PROPERTIES => [new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameProperty(\_PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\PropertyFetch\RenamePropertyRector\Source\ClassWithProperties::class, 'oldProperty', 'newProperty'), new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameProperty(\_PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\PropertyFetch\RenamePropertyRector\Source\ClassWithProperties::class, 'anotherOldProperty', 'anotherNewProperty')]]];
    }
}
