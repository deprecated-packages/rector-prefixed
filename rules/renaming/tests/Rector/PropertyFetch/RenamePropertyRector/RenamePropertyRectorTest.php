<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\PropertyFetch\RenamePropertyRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector;
use _PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\PropertyFetch\RenamePropertyRector\Source\ClassWithProperties;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameProperty;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class RenamePropertyRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScopere8e811afab72\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::class => [\_PhpScopere8e811afab72\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::RENAMED_PROPERTIES => [new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameProperty(\_PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\PropertyFetch\RenamePropertyRector\Source\ClassWithProperties::class, 'oldProperty', 'newProperty'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameProperty(\_PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\PropertyFetch\RenamePropertyRector\Source\ClassWithProperties::class, 'anotherOldProperty', 'anotherNewProperty')]]];
    }
}
