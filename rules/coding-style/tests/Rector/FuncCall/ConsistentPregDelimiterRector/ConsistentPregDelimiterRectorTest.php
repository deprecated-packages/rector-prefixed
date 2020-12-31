<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Tests\Rector\FuncCall\ConsistentPregDelimiterRector;

use Iterator;
use Rector\CodingStyle\Rector\FuncCall\ConsistentPregDelimiterRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20201231\Symplify\SmartFileSystem\SmartFileInfo;
final class ConsistentPregDelimiterRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20201231\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\CodingStyle\Rector\FuncCall\ConsistentPregDelimiterRector::class;
    }
}
