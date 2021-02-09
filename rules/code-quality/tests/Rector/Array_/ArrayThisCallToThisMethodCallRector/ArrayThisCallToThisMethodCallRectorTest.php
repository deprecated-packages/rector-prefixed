<?php

declare (strict_types=1);
namespace Rector\CodeQuality\Tests\Rector\Array_\ArrayThisCallToThisMethodCallRector;

use Iterator;
use Rector\CodeQuality\Rector\Array_\ArrayThisCallToThisMethodCallRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210209\Symplify\SmartFileSystem\SmartFileInfo;
final class ArrayThisCallToThisMethodCallRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210209\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\CodeQuality\Rector\Array_\ArrayThisCallToThisMethodCallRector::class;
    }
}
