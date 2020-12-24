<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodingStyle\Tests\Rector\Namespace_\ImportFullyQualifiedNamesRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Core\Configuration\Option;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Rector\PostRector\Rector\NameImportingPostRector
 */
final class ImportRootNamespaceClassesDisabledTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->setParameter(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES, \true);
        $this->setParameter(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::IMPORT_SHORT_CLASSES, \false);
        $this->doTestFileInfo($fileInfo);
    }
    /**
     * @return Iterator
     */
    public function provideData() : iterable
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureRoot');
    }
    protected function getRectorClass() : string
    {
        // the must be any rector class to run
        return \_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::class;
    }
}
