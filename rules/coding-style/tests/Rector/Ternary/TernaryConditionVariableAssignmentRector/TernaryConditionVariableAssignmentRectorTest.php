<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Tests\Rector\Ternary\TernaryConditionVariableAssignmentRector;

use Iterator;
use Rector\CodingStyle\Rector\Ternary\TernaryConditionVariableAssignmentRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20201227\Symplify\SmartFileSystem\SmartFileInfo;
final class TernaryConditionVariableAssignmentRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20201227\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\CodingStyle\Rector\Ternary\TernaryConditionVariableAssignmentRector::class;
    }
}
