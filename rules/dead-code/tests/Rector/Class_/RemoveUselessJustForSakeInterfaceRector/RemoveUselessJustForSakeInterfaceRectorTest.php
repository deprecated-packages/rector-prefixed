<?php

declare (strict_types=1);
namespace Rector\DeadCode\Tests\Rector\Class_\RemoveUselessJustForSakeInterfaceRector;

use Iterator;
use Rector\DeadCode\Rector\Class_\RemoveUselessJustForSakeInterfaceRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210115\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveUselessJustForSakeInterfaceRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210115\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\DeadCode\Rector\Class_\RemoveUselessJustForSakeInterfaceRector::class;
    }
}
