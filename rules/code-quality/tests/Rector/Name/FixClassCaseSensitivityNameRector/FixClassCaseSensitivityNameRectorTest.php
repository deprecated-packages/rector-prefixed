<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodeQuality\Tests\Rector\Name\FixClassCaseSensitivityNameRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\CodeQuality\Rector\Name\FixClassCaseSensitivityNameRector;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class FixClassCaseSensitivityNameRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        // for PHPStan class reflection
        require_once __DIR__ . '/Source/MissCaseTypedClass.php';
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoper0a6b37af0871\Rector\CodeQuality\Rector\Name\FixClassCaseSensitivityNameRector::class;
    }
}
