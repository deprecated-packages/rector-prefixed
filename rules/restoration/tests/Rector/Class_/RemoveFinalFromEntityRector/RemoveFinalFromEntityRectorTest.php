<?php

declare (strict_types=1);
namespace Rector\Restoration\Tests\Rector\Class_\RemoveFinalFromEntityRector;

use Iterator;
use Rector\Restoration\Rector\Class_\RemoveFinalFromEntityRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210206\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveFinalFromEntityRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210206\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Restoration\Rector\Class_\RemoveFinalFromEntityRector::class;
    }
}
