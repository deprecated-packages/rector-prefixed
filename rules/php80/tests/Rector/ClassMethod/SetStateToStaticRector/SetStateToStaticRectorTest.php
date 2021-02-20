<?php

declare (strict_types=1);
namespace Rector\Php80\Tests\Rector\ClassMethod\SetStateToStaticRector;

use Iterator;
use Rector\Php80\Rector\ClassMethod\SetStateToStaticRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210220\Symplify\SmartFileSystem\SmartFileInfo;
final class SetStateToStaticRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     * @requires PHP < 8.0
     */
    public function test(\RectorPrefix20210220\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Php80\Rector\ClassMethod\SetStateToStaticRector::class;
    }
}
