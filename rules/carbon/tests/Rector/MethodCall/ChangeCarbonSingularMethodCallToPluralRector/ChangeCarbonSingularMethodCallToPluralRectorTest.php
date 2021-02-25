<?php

declare (strict_types=1);
namespace Rector\Carbon\Tests\Rector\MethodCall\ChangeCarbonSingularMethodCallToPluralRector;

use Iterator;
use Rector\Carbon\Rector\MethodCall\ChangeCarbonSingularMethodCallToPluralRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210225\Symplify\SmartFileSystem\SmartFileInfo;
final class ChangeCarbonSingularMethodCallToPluralRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210225\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Carbon\Rector\MethodCall\ChangeCarbonSingularMethodCallToPluralRector::class;
    }
}
