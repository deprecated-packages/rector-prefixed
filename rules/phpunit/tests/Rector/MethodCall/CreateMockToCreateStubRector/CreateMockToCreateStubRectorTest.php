<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Tests\Rector\MethodCall\CreateMockToCreateStubRector;

use Iterator;
use Rector\PHPUnit\Rector\MethodCall\CreateMockToCreateStubRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210212\Symplify\SmartFileSystem\SmartFileInfo;
final class CreateMockToCreateStubRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210212\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\PHPUnit\Rector\MethodCall\CreateMockToCreateStubRector::class;
    }
}
