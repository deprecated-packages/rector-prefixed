<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Tests\Rector\String_\SymplifyQuoteEscapeRector;

use Iterator;
use Rector\CodingStyle\Rector\String_\SymplifyQuoteEscapeRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210212\Symplify\SmartFileSystem\SmartFileInfo;
final class SymplifyQuoteEscapeRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210212\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\CodingStyle\Rector\String_\SymplifyQuoteEscapeRector::class;
    }
}
