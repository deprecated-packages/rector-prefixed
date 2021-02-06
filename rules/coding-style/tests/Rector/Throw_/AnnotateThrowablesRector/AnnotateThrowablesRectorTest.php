<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector;

use Iterator;
use Rector\CodingStyle\Rector\Throw_\AnnotateThrowablesRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210206\Symplify\SmartFileSystem\SmartFileInfo;
final class AnnotateThrowablesRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210206\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\CodingStyle\Rector\Throw_\AnnotateThrowablesRector::class;
    }
}
