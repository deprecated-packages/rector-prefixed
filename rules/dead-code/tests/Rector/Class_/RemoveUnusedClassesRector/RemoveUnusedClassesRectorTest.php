<?php

declare (strict_types=1);
namespace Rector\DeadCode\Tests\Rector\Class_\RemoveUnusedClassesRector;

use Iterator;
use Rector\DeadCode\Rector\Class_\RemoveUnusedClassesRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210117\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveUnusedClassesRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210117\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\DeadCode\Rector\Class_\RemoveUnusedClassesRector::class;
    }
}
