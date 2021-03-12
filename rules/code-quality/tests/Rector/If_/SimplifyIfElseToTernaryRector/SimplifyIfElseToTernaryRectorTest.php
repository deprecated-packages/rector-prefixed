<?php

declare (strict_types=1);
namespace Rector\CodeQuality\Tests\Rector\If_\SimplifyIfElseToTernaryRector;

use Iterator;
use Rector\CodeQuality\Rector\If_\SimplifyIfElseToTernaryRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210312\Symplify\SmartFileSystem\SmartFileInfo;
final class SimplifyIfElseToTernaryRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210312\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\CodeQuality\Rector\If_\SimplifyIfElseToTernaryRector::class;
    }
}
