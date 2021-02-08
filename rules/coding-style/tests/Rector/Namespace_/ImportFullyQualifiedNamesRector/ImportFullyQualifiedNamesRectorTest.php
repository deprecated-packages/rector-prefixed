<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Tests\Rector\Namespace_\ImportFullyQualifiedNamesRector;

use Iterator;
use Rector\Core\Configuration\Option;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210208\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Rector\PostRector\Rector\NameImportingPostRector
 */
final class ImportFullyQualifiedNamesRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     * @dataProvider provideDataFunction()
     * @dataProvider provideDataGeneric()
     */
    public function test(\RectorPrefix20210208\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->setParameter(\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES, \true);
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    public function provideDataFunction() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureFunction');
    }
    public function provideDataGeneric() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureGeneric');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Renaming\Rector\Name\RenameClassRector::class;
    }
}
