<?php

declare (strict_types=1);
namespace Rector\DeadCode\Tests\Rector\Assign\RemoveUnusedAssignVariableRector;

use Iterator;
use Rector\DeadCode\Rector\Assign\RemoveUnusedAssignVariableRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveUnusedAssignVariableRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\DeadCode\Rector\Assign\RemoveUnusedAssignVariableRector::class;
    }
}
