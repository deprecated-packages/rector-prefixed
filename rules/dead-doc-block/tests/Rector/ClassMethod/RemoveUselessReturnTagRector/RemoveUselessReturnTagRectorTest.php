<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DeadDocBlock\Tests\Rector\ClassMethod\RemoveUselessReturnTagRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\DeadDocBlock\Rector\ClassMethod\RemoveUselessReturnTagRector;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use SplFileInfo;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveUselessReturnTagRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    /**
     * @return Iterator<SplFileInfo>
     */
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoperb75b35f52b74\Rector\DeadDocBlock\Rector\ClassMethod\RemoveUselessReturnTagRector::class;
    }
}
