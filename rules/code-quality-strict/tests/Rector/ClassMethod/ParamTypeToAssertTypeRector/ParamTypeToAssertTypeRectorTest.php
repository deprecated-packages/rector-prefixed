<?php

declare (strict_types=1);
namespace Rector\CodeQualityStrict\Tests\Rector\ClassMethod\ParamTypeToAssertTypeRector;

use Iterator;
use Rector\CodeQualityStrict\Rector\ClassMethod\ParamTypeToAssertTypeRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210127\Symplify\SmartFileSystem\SmartFileInfo;
final class ParamTypeToAssertTypeRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210127\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\CodeQualityStrict\Rector\ClassMethod\ParamTypeToAssertTypeRector::class;
    }
}
