<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Tests\Rector\Use_\SplitGroupedUseImportsRector;

use Iterator;
use Rector\CodingStyle\Rector\Use_\SplitGroupedUseImportsRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20201229\Symplify\SmartFileSystem\SmartFileInfo;
final class SplitGroupedUseImportsRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20201229\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\CodingStyle\Rector\Use_\SplitGroupedUseImportsRector::class;
    }
}
