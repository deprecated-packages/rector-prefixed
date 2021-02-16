<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Tests\Rector\MethodCall\AssertEqualsToSameRector;

use Iterator;
use Rector\PHPUnit\Rector\MethodCall\AssertEqualsToSameRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210216\Symplify\SmartFileSystem\SmartFileInfo;
final class AssertEqualsToSameRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210216\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\PHPUnit\Rector\MethodCall\AssertEqualsToSameRector::class;
    }
}
