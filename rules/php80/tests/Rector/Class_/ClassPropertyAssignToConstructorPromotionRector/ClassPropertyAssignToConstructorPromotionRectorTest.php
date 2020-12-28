<?php

declare (strict_types=1);
namespace Rector\Php80\Tests\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;

use Iterator;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20201228\Symplify\SmartFileSystem\SmartFileInfo;
final class ClassPropertyAssignToConstructorPromotionRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @requires PHP 7.4
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20201228\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector::class;
    }
}
