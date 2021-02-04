<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\Tests\Rector\Assign\MakeGetComponentAssignAnnotatedRector;

use Iterator;
use Rector\Core\Configuration\Option;
use Rector\NetteCodeQuality\Rector\Assign\MakeGetComponentAssignAnnotatedRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210204\Symplify\SmartFileSystem\SmartFileInfo;
final class AutoImportTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210204\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->setParameter(\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES, \true);
        $this->setParameter(\Rector\Core\Configuration\Option::IMPORT_DOC_BLOCKS, \true);
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureAutoImport');
    }
    protected function getRectorClass() : string
    {
        return \Rector\NetteCodeQuality\Rector\Assign\MakeGetComponentAssignAnnotatedRector::class;
    }
}
