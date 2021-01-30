<?php

declare (strict_types=1);
namespace Rector\Performance\Tests\Rector\FuncCall\PreslashSimpleFunctionRector;

use Iterator;
use Rector\Core\Configuration\Option;
use Rector\Performance\Rector\FuncCall\PreslashSimpleFunctionRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210130\Symplify\SmartFileSystem\SmartFileInfo;
final class AutoImportTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210130\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->setParameter(\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES, \true);
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureAutoImport');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Performance\Rector\FuncCall\PreslashSimpleFunctionRector::class;
    }
}
