<?php

declare (strict_types=1);
namespace Rector\Laravel\Tests\Rector\ClassMethod\AddParentBootToModelClassMethodRector;

use Iterator;
use Rector\Laravel\Rector\ClassMethod\AddParentBootToModelClassMethodRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210111\Symplify\SmartFileSystem\SmartFileInfo;
final class AddParentBootToModelClassMethodRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210111\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Laravel\Rector\ClassMethod\AddParentBootToModelClassMethodRector::class;
    }
}
