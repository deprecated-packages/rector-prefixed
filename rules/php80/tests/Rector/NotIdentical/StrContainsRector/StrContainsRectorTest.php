<?php

declare (strict_types=1);
namespace Rector\Php80\Tests\Rector\NotIdentical\StrContainsRector;

use Iterator;
use Rector\Php80\Rector\NotIdentical\StrContainsRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210228\Symplify\SmartFileSystem\SmartFileInfo;
final class StrContainsRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210228\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Php80\Rector\NotIdentical\StrContainsRector::class;
    }
}
