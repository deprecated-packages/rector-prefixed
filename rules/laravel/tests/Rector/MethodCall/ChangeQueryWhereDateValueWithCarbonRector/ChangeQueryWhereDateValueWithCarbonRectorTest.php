<?php

declare (strict_types=1);
namespace Rector\Laravel\Tests\Rector\MethodCall\ChangeQueryWhereDateValueWithCarbonRector;

use Iterator;
use Rector\Laravel\Rector\MethodCall\ChangeQueryWhereDateValueWithCarbonRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210126\Symplify\SmartFileSystem\SmartFileInfo;
final class ChangeQueryWhereDateValueWithCarbonRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210126\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Laravel\Rector\MethodCall\ChangeQueryWhereDateValueWithCarbonRector::class;
    }
}
