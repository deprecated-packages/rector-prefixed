<?php

declare (strict_types=1);
namespace Rector\CodeQuality\Tests\Rector\New_\NewStaticToNewSelfRector;

use Iterator;
use Rector\CodeQuality\Rector\New_\NewStaticToNewSelfRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20201229\Symplify\SmartFileSystem\SmartFileInfo;
final class NewStaticToNewSelfRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20201229\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\CodeQuality\Rector\New_\NewStaticToNewSelfRector::class;
    }
}
