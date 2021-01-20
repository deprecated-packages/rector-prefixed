<?php

declare (strict_types=1);
namespace Rector\Privatization\Tests\Rector\MethodCall\PrivatizeLocalGetterToPropertyRector;

use Iterator;
use Rector\Privatization\Rector\MethodCall\PrivatizeLocalGetterToPropertyRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210120\Symplify\SmartFileSystem\SmartFileInfo;
final class PrivatizeLocalGetterToPropertyRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210120\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Privatization\Rector\MethodCall\PrivatizeLocalGetterToPropertyRector::class;
    }
}
