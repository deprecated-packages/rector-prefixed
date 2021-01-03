<?php

declare (strict_types=1);
namespace Rector\CodeQuality\Tests\Rector\NotEqual\CommonNotEqualRector;

use Iterator;
use Rector\CodeQuality\Rector\NotEqual\CommonNotEqualRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210103\Symplify\SmartFileSystem\SmartFileInfo;
final class CommonNotEqualRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210103\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\CodeQuality\Rector\NotEqual\CommonNotEqualRector::class;
    }
}
