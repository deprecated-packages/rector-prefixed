<?php

declare (strict_types=1);
namespace Rector\PHPOffice\Tests\Rector\MethodCall\ChangeConditionalGetConditionRector;

use Iterator;
use Rector\PHPOffice\Rector\MethodCall\ChangeConditionalGetConditionRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210204\Symplify\SmartFileSystem\SmartFileInfo;
final class ChangeConditionalGetConditionRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210204\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\PHPOffice\Rector\MethodCall\ChangeConditionalGetConditionRector::class;
    }
}
