<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Renaming\Tests\Rector\PropertyFetch\RenamePropertyRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector;
use _PhpScoper0a6b37af0871\Rector\Renaming\Tests\Rector\PropertyFetch\RenamePropertyRector\Source\ClassWithProperties;
use _PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\RenameProperty;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class RenamePropertyRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::class => [\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::RENAMED_PROPERTIES => [new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\RenameProperty(\_PhpScoper0a6b37af0871\Rector\Renaming\Tests\Rector\PropertyFetch\RenamePropertyRector\Source\ClassWithProperties::class, 'oldProperty', 'newProperty'), new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\RenameProperty(\_PhpScoper0a6b37af0871\Rector\Renaming\Tests\Rector\PropertyFetch\RenamePropertyRector\Source\ClassWithProperties::class, 'anotherOldProperty', 'anotherNewProperty')]]];
    }
}
