<?php

declare (strict_types=1);
namespace Rector\Defluent\Tests\Rector\ClassMethod\ReturnThisRemoveRector;

use Iterator;
use Rector\Defluent\Rector\ClassMethod\ReturnThisRemoveRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210301\Symplify\SmartFileSystem\SmartFileInfo;
final class ReturnThisRemoveRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210301\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Defluent\Rector\ClassMethod\ReturnThisRemoveRector::class;
    }
}
