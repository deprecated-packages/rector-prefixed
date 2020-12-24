<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Php72\Tests\Rector\FuncCall\ParseStrWithResultArgumentRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Php72\Rector\FuncCall\ParseStrWithResultArgumentRector;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @requires PHP < 8.0
 */
final class ParseStrWithResultArgumentRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return \_PhpScoper0a6b37af0871\Rector\Php72\Rector\FuncCall\ParseStrWithResultArgumentRector::class;
    }
}
