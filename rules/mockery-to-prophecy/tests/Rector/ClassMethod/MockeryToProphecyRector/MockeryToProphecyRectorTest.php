<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\MockeryToProphecy\Tests\Rector\ClassMethod\MockeryToProphecyRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\MockeryToProphecy\Rector\ClassMethod\MockeryCreateMockToProphizeRector;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class MockeryToProphecyRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $file) : void
    {
        $this->doTestFileInfo($file);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoper0a6b37af0871\Rector\MockeryToProphecy\Rector\ClassMethod\MockeryCreateMockToProphizeRector::class;
    }
}
