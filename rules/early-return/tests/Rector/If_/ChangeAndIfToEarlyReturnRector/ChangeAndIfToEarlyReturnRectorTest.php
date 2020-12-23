<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\EarlyReturn\Tests\Rector\If_\ChangeAndIfToEarlyReturnRector;

use Iterator;
use _PhpScoper0a2ac50786fa\Rector\EarlyReturn\Rector\If_\ChangeAndIfToEarlyReturnRector;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class ChangeAndIfToEarlyReturnRectorTest extends \_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
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
        return \_PhpScoper0a2ac50786fa\Rector\EarlyReturn\Rector\If_\ChangeAndIfToEarlyReturnRector::class;
    }
}
