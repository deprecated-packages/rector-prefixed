<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Tests\Rector\Class_\AddProphecyTraitRector;

use Iterator;
use Rector\PHPUnit\Rector\Class_\AddProphecyTraitRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210128\Symplify\SmartFileSystem\SmartFileInfo;
final class AddProphecyTraitRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210128\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\PHPUnit\Rector\Class_\AddProphecyTraitRector::class;
    }
}
