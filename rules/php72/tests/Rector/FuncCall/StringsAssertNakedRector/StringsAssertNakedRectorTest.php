<?php

declare (strict_types=1);
namespace Rector\Php72\Tests\Rector\FuncCall\StringsAssertNakedRector;

use Iterator;
use Rector\Php72\Rector\FuncCall\StringsAssertNakedRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210213\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @requires PHP < 8.0
 */
final class StringsAssertNakedRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210213\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Php72\Rector\FuncCall\StringsAssertNakedRector::class;
    }
}
