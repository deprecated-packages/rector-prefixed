<?php

declare (strict_types=1);
namespace Rector\CodeQuality\Tests\Rector\Ternary\SwitchNegatedTernaryRector;

use Iterator;
use Rector\CodeQuality\Rector\Ternary\SwitchNegatedTernaryRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210215\Symplify\SmartFileSystem\SmartFileInfo;
final class SwitchNegatedTernaryRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210215\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\CodeQuality\Rector\Ternary\SwitchNegatedTernaryRector::class;
    }
}
