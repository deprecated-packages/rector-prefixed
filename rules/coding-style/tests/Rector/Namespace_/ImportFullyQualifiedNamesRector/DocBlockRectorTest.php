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
final class DocBlockRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->setParameter(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES, \true);
        $this->setParameter(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::IMPORT_DOC_BLOCKS, \true);
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureDocBlock');
    }
    protected function getRectorClass() : string
    {
        // here can be any Rector rule, as we're testing \Rector\PostRector\Rector\NameImportingPostRector in the full Retcor life cycle
        return \_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::class;
    }
}
