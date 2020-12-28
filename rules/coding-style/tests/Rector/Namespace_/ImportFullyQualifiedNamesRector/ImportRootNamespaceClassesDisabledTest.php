<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Tests\Rector\Namespace_\ImportFullyQualifiedNamesRector;

use Iterator;
use Rector\Core\Configuration\Option;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20201228\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Rector\PostRector\Rector\NameImportingPostRector
 */
final class ImportRootNamespaceClassesDisabledTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20201228\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->setParameter(\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES, \true);
        $this->setParameter(\Rector\Core\Configuration\Option::IMPORT_SHORT_CLASSES, \false);
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
        return \Rector\Renaming\Rector\Name\RenameClassRector::class;
    }
}
