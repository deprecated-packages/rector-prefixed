<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DeadCode\Tests\Rector\StaticCall\RemoveParentCallWithoutParentRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveParentCallWithoutParentRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @requires PHP < 8.0
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
        return \_PhpScoper0a6b37af0871\Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector::class;
    }
}
