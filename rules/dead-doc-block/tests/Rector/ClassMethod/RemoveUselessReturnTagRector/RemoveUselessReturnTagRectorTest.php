<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DeadDocBlock\Tests\Rector\ClassMethod\RemoveUselessReturnTagRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\DeadDocBlock\Rector\ClassMethod\RemoveUselessReturnTagRector;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use SplFileInfo;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveUselessReturnTagRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    /**
     * @return Iterator<SplFileInfo>
     */
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoper0a6b37af0871\Rector\DeadDocBlock\Rector\ClassMethod\RemoveUselessReturnTagRector::class;
    }
}
