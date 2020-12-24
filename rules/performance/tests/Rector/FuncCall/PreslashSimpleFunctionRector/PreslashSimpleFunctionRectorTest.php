<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Performance\Tests\Rector\FuncCall\PreslashSimpleFunctionRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Rector\Performance\Rector\FuncCall\PreslashSimpleFunctionRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class PreslashSimpleFunctionRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return \_PhpScoper2a4e7ab1ecbc\Rector\Performance\Rector\FuncCall\PreslashSimpleFunctionRector::class;
    }
}
