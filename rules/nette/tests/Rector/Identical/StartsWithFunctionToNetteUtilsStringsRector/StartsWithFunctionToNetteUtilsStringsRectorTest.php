<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Nette\Tests\Rector\Identical\StartsWithFunctionToNetteUtilsStringsRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Nette\Rector\Identical\StartsWithFunctionToNetteUtilsStringsRector;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class StartsWithFunctionToNetteUtilsStringsRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoper0a6b37af0871\Rector\Nette\Rector\Identical\StartsWithFunctionToNetteUtilsStringsRector::class;
    }
}
