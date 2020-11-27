<?php

declare (strict_types=1);
namespace Rector\StrictCodeQuality\Tests\Rector\ClassMethod\ParamTypeToAssertTypeRector;

use Iterator;
use Rector\StrictCodeQuality\Rector\ClassMethod\ParamTypeToAssertTypeRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
final class ParamTypeToAssertTypeRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\StrictCodeQuality\Rector\ClassMethod\ParamTypeToAssertTypeRector::class;
    }
}
