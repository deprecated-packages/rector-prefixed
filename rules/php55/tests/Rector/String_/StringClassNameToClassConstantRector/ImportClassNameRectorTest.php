<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Php55\Tests\Rector\String_\StringClassNameToClassConstantRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Core\Configuration\Option;
use _PhpScoper0a6b37af0871\Rector\Php55\Rector\String_\StringClassNameToClassConstantRector;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class ImportClassNameRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->setParameter(\_PhpScoper0a6b37af0871\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES, \true);
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureImport');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoper0a6b37af0871\Rector\Php55\Rector\String_\StringClassNameToClassConstantRector::class;
    }
}
