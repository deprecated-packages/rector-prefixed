<?php

declare (strict_types=1);
namespace Rector\PHPStan\Tests\Rector\Assign\PHPStormVarAnnotationRector;

use Iterator;
use Rector\PHPStan\Rector\Assign\PHPStormVarAnnotationRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
final class PHPStormVarAnnotationRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return \Rector\PHPStan\Rector\Assign\PHPStormVarAnnotationRector::class;
    }
}
