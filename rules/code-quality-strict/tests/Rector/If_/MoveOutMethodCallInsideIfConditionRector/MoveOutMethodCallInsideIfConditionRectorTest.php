<?php

declare (strict_types=1);
namespace Rector\CodeQualityStrict\Tests\Rector\If_\MoveOutMethodCallInsideIfConditionRector;

use Iterator;
use Rector\CodeQualityStrict\Rector\If_\MoveOutMethodCallInsideIfConditionRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210102\Symplify\SmartFileSystem\SmartFileInfo;
final class MoveOutMethodCallInsideIfConditionRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210102\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\CodeQualityStrict\Rector\If_\MoveOutMethodCallInsideIfConditionRector::class;
    }
}
