<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Tests\Rector\Assign\ManualJsonStringToJsonEncodeArrayRector;

use Iterator;
use Rector\CodingStyle\Rector\Assign\ManualJsonStringToJsonEncodeArrayRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210225\Symplify\SmartFileSystem\SmartFileInfo;
final class ManualJsonStringToJsonEncodeArrayRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210225\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\CodingStyle\Rector\Assign\ManualJsonStringToJsonEncodeArrayRector::class;
    }
}
