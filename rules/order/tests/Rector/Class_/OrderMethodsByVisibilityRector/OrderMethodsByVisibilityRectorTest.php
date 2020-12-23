<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Order\Tests\Rector\Class_\OrderMethodsByVisibilityRector;

use Iterator;
use _PhpScoper0a2ac50786fa\Rector\Order\Rector\Class_\OrderMethodsByVisibilityRector;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class OrderMethodsByVisibilityRectorTest extends \_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * Final + private method breaks :)
     * @requires PHP < 8.0
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoper0a2ac50786fa\Rector\Order\Rector\Class_\OrderMethodsByVisibilityRector::class;
    }
}
