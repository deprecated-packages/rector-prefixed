<?php

declare (strict_types=1);
namespace Rector\Restoration\Tests\Rector\ClassConstFetch\MissingClassConstantReferenceToStringRector;

use Iterator;
use Rector\Restoration\Rector\ClassConstFetch\MissingClassConstantReferenceToStringRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210213\Symplify\SmartFileSystem\SmartFileInfo;
final class MissingClassConstantReferenceToStringRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210213\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Restoration\Rector\ClassConstFetch\MissingClassConstantReferenceToStringRector::class;
    }
}
