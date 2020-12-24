<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Php55\Tests\Rector\String_\StringClassNameToClassConstantRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Configuration\Option;
use _PhpScoper2a4e7ab1ecbc\Rector\Php55\Rector\String_\StringClassNameToClassConstantRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class ImportClassNameRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->setParameter(\_PhpScoper2a4e7ab1ecbc\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES, \true);
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureImport');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoper2a4e7ab1ecbc\Rector\Php55\Rector\String_\StringClassNameToClassConstantRector::class;
    }
}
