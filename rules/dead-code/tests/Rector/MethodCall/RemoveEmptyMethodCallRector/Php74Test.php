<?php

declare (strict_types=1);
namespace Rector\DeadCode\Tests\Rector\MethodCall\RemoveEmptyMethodCallRector;

use Iterator;
use Rector\DeadCode\Rector\MethodCall\RemoveEmptyMethodCallRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210308\Symplify\SmartFileSystem\SmartFileInfo;
final class Php74Test extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @requires PHP 7.4
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210308\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixturePhp74');
    }
    protected function getRectorClass() : string
    {
        return \Rector\DeadCode\Rector\MethodCall\RemoveEmptyMethodCallRector::class;
    }
}
