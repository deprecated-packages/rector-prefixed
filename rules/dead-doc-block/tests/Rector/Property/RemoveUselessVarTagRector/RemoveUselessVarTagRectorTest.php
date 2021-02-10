<?php

declare (strict_types=1);
namespace Rector\DeadDocBlock\Tests\Rector\Property\RemoveUselessVarTagRector;

use Iterator;
use Rector\DeadDocBlock\Rector\Property\RemoveUselessVarTagRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210210\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveUselessVarTagRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @requires PHP 7.4
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210210\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\DeadDocBlock\Rector\Property\RemoveUselessVarTagRector::class;
    }
}
