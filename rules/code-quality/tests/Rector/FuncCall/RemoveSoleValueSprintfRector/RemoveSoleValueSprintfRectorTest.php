<?php

declare (strict_types=1);
namespace Rector\CodeQuality\Tests\Rector\FuncCall\RemoveSoleValueSprintfRector;

use Iterator;
use Rector\CodeQuality\Rector\FuncCall\RemoveSoleValueSprintfRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210223\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveSoleValueSprintfRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210223\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\CodeQuality\Rector\FuncCall\RemoveSoleValueSprintfRector::class;
    }
}
