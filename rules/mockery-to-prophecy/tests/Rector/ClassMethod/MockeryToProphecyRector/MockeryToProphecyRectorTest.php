<?php

declare (strict_types=1);
namespace Rector\MockeryToProphecy\Tests\Rector\ClassMethod\MockeryToProphecyRector;

use Iterator;
use Rector\MockeryToProphecy\Rector\ClassMethod\MockeryCreateMockToProphizeRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210211\Symplify\SmartFileSystem\SmartFileInfo;
final class MockeryToProphecyRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210211\Symplify\SmartFileSystem\SmartFileInfo $file) : void
    {
        $this->doTestFileInfo($file);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\MockeryToProphecy\Rector\ClassMethod\MockeryCreateMockToProphizeRector::class;
    }
}
