<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Tests\Rector\PostInc\PostIncDecToPreIncDecRector;

use Iterator;
use Rector\CodingStyle\Rector\PostInc\PostIncDecToPreIncDecRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210311\Symplify\SmartFileSystem\SmartFileInfo;
final class PostIncDecToPreIncDecRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210311\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\CodingStyle\Rector\PostInc\PostIncDecToPreIncDecRector::class;
    }
}
