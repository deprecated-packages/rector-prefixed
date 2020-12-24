<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\StrictCodeQuality\Tests\Rector\ClassMethod\ParamTypeToAssertTypeRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Rector\StrictCodeQuality\Rector\ClassMethod\ParamTypeToAssertTypeRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class ParamTypeToAssertTypeRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoper2a4e7ab1ecbc\Rector\StrictCodeQuality\Rector\ClassMethod\ParamTypeToAssertTypeRector::class;
    }
}
