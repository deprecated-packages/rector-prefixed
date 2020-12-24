<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php80\Tests\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class ClassPropertyAssignToConstructorPromotionRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @requires PHP 7.4
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoperb75b35f52b74\Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector::class;
    }
}
