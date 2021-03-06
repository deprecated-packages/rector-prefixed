<?php

declare (strict_types=1);
namespace Rector\Naming\Tests\Rector\Foreach_\RenameForeachValueVariableToMatchExprVariableRector;

use Iterator;
use Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchExprVariableRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210306\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameForeachValueVariableToMatchExprVariableRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210306\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchExprVariableRector::class;
    }
}
