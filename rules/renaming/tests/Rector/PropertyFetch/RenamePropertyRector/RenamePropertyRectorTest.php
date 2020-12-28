<?php

declare (strict_types=1);
namespace Rector\Renaming\Tests\Rector\PropertyFetch\RenamePropertyRector;

use Iterator;
use Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector;
use Rector\Renaming\Tests\Rector\PropertyFetch\RenamePropertyRector\Source\ClassWithProperties;
use Rector\Renaming\ValueObject\RenameProperty;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20201228\Symplify\SmartFileSystem\SmartFileInfo;
final class RenamePropertyRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::class => [\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::RENAMED_PROPERTIES => [new \Rector\Renaming\ValueObject\RenameProperty(\Rector\Renaming\Tests\Rector\PropertyFetch\RenamePropertyRector\Source\ClassWithProperties::class, 'oldProperty', 'newProperty'), new \Rector\Renaming\ValueObject\RenameProperty(\Rector\Renaming\Tests\Rector\PropertyFetch\RenamePropertyRector\Source\ClassWithProperties::class, 'anotherOldProperty', 'anotherNewProperty')]]];
    }
}
