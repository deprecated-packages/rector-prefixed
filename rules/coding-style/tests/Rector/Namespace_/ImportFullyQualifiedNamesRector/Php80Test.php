<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Tests\Rector\Namespace_\ImportFullyQualifiedNamesRector;

use Iterator;
use Rector\Core\Configuration\Option;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210114\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Rector\PostRector\Rector\NameImportingPostRector
 */
final class Php80Test extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @requires PHP 8.0
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210114\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->setParameter(\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES, \true);
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureAttributes');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Renaming\Rector\Name\RenameClassRector::class;
    }
}
