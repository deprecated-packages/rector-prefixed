<?php

declare (strict_types=1);
namespace Rector\Privatization\Tests\Rector\Class_\ChangeLocalPropertyToVariableRector;

use Iterator;
use Rector\Privatization\Rector\Class_\ChangeLocalPropertyToVariableRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
final class ChangeLocalPropertyToVariableRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return \Rector\Privatization\Rector\Class_\ChangeLocalPropertyToVariableRector::class;
    }
}
