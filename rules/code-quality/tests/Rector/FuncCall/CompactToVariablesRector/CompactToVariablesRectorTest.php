<?php

declare (strict_types=1);
namespace Rector\CodeQuality\Tests\Rector\FuncCall\CompactToVariablesRector;

use Iterator;
use Rector\CodeQuality\Rector\FuncCall\CompactToVariablesRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210114\Symplify\SmartFileSystem\SmartFileInfo;
final class CompactToVariablesRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210114\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\CodeQuality\Rector\FuncCall\CompactToVariablesRector::class;
    }
}
