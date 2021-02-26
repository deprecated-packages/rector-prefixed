<?php

declare (strict_types=1);
namespace Rector\DeadCode\Tests\Rector\ClassMethod\RemoveUnusedConstructorParamRector;

use Iterator;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedConstructorParamRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210226\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveUnusedConstructorParamRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210226\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\DeadCode\Rector\ClassMethod\RemoveUnusedConstructorParamRector::class;
    }
}
