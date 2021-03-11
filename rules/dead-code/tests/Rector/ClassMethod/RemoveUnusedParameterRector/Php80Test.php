<?php

declare (strict_types=1);
namespace Rector\DeadCode\Tests\Rector\ClassMethod\RemoveUnusedParameterRector;

use Iterator;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedParameterRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210311\Symplify\SmartFileSystem\SmartFileInfo;
final class Php80Test extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @requires PHP 8.0
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210311\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixturePhp80');
    }
    protected function getRectorClass() : string
    {
        return \Rector\DeadCode\Rector\ClassMethod\RemoveUnusedParameterRector::class;
    }
}
