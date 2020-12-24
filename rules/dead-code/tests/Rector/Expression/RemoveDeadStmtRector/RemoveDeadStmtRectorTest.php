<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DeadCode\Tests\Rector\Expression\RemoveDeadStmtRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\DeadCode\Rector\Expression\RemoveDeadStmtRector;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveDeadStmtRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
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
    /**
     * @dataProvider provideDataForTestKeepComments()
     */
    public function testKeepComments(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideDataForTestKeepComments() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureRemovedComments');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoperb75b35f52b74\Rector\DeadCode\Rector\Expression\RemoveDeadStmtRector::class;
    }
}
