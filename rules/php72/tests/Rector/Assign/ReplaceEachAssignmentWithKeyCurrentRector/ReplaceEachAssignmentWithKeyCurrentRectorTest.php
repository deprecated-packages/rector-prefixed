<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php72\Tests\Rector\Assign\ReplaceEachAssignmentWithKeyCurrentRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Php72\Rector\Assign\ReplaceEachAssignmentWithKeyCurrentRector;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use SplFileInfo;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class ReplaceEachAssignmentWithKeyCurrentRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     * @requires PHP < 8.0
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
        return \_PhpScoperb75b35f52b74\Rector\Php72\Rector\Assign\ReplaceEachAssignmentWithKeyCurrentRector::class;
    }
}
