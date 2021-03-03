<?php

declare (strict_types=1);
namespace Rector\Php54\Tests\Rector\Break_\RemoveZeroBreakContinueRector;

use Iterator;
use Rector\Php54\Rector\Break_\RemoveZeroBreakContinueRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210303\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveZeroBreakContinueRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210303\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        // to prevent loading PHP 5.4+ invalid code
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Php54\Rector\Break_\RemoveZeroBreakContinueRector::class;
    }
}
