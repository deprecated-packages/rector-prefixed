<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\PropertyFetch\RenamePropertyRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\PropertyFetch\RenamePropertyRector\Source\ClassWithProperties;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameProperty;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class RenamePropertyRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::class => [\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::RENAMED_PROPERTIES => [new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameProperty(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\PropertyFetch\RenamePropertyRector\Source\ClassWithProperties::class, 'oldProperty', 'newProperty'), new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameProperty(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\PropertyFetch\RenamePropertyRector\Source\ClassWithProperties::class, 'anotherOldProperty', 'anotherNewProperty')]]];
    }
}
