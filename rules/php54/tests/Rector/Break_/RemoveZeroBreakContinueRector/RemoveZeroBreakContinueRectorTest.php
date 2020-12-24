<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php54\Tests\Rector\Break_\RemoveZeroBreakContinueRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Php54\Rector\Break_\RemoveZeroBreakContinueRector;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveZeroBreakContinueRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return \_PhpScoperb75b35f52b74\Rector\Php54\Rector\Break_\RemoveZeroBreakContinueRector::class;
    }
}
