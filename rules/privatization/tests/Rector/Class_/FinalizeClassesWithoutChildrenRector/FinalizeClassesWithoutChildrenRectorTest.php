<?php

declare (strict_types=1);
namespace Rector\Privatization\Tests\Rector\Class_\FinalizeClassesWithoutChildrenRector;

use Iterator;
use Rector\Privatization\Rector\Class_\FinalizeClassesWithoutChildrenRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20201227\Symplify\SmartFileSystem\SmartFileInfo;
final class FinalizeClassesWithoutChildrenRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20201227\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Privatization\Rector\Class_\FinalizeClassesWithoutChildrenRector::class;
    }
}
