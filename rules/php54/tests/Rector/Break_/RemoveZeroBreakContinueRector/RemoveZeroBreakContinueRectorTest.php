<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Php54\Tests\Rector\Break_\RemoveZeroBreakContinueRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Php54\Rector\Break_\RemoveZeroBreakContinueRector;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveZeroBreakContinueRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        // to prevent loading PHP 5.4+ invalid code
        $this->doTestFileInfoWithoutAutoload($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoper0a6b37af0871\Rector\Php54\Rector\Break_\RemoveZeroBreakContinueRector::class;
    }
}
