<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\Tests\Rector\Assign\ArrayAccessSetControlToAddComponentMethodCallRector;

use Iterator;
use Rector\NetteCodeQuality\Rector\Assign\ArrayAccessSetControlToAddComponentMethodCallRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
final class ArrayAccessSetControlToAddComponentMethodCallRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\NetteCodeQuality\Rector\Assign\ArrayAccessSetControlToAddComponentMethodCallRector::class;
    }
}
