<?php

declare (strict_types=1);
namespace Rector\Phalcon\Tests\Rector\MethodCall\AddRequestToHandleMethodCallRector;

use Iterator;
use Rector\Phalcon\Rector\MethodCall\AddRequestToHandleMethodCallRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20201227\Symplify\SmartFileSystem\SmartFileInfo;
final class AddRequestToHandleMethodCallRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20201227\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Phalcon\Rector\MethodCall\AddRequestToHandleMethodCallRector::class;
    }
}
