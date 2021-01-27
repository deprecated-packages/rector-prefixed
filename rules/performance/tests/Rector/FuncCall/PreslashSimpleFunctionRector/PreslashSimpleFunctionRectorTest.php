<?php

declare (strict_types=1);
namespace Rector\Performance\Tests\Rector\FuncCall\PreslashSimpleFunctionRector;

use Iterator;
use Rector\Performance\Rector\FuncCall\PreslashSimpleFunctionRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210127\Symplify\SmartFileSystem\SmartFileInfo;
final class PreslashSimpleFunctionRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return \Rector\Performance\Rector\FuncCall\PreslashSimpleFunctionRector::class;
    }
}
