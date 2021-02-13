<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Tests\Rector\String_\UseClassKeywordForClassNameResolutionRector;

use Iterator;
use Rector\CodingStyle\Rector\String_\UseClassKeywordForClassNameResolutionRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210213\Symplify\SmartFileSystem\SmartFileInfo;
final class UseClassKeywordForClassNameResolutionRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210213\Symplify\SmartFileSystem\SmartFileInfo $file) : void
    {
        $this->doTestFileInfo($file);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\CodingStyle\Rector\String_\UseClassKeywordForClassNameResolutionRector::class;
    }
}
