<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\MockeryToProphecy\Tests\Rector\ClassMethod\MockeryToProphecyRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\MockeryToProphecy\Rector\ClassMethod\MockeryCreateMockToProphizeRector;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class MockeryToProphecyRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $file) : void
    {
        $this->doTestFileInfo($file);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoperb75b35f52b74\Rector\MockeryToProphecy\Rector\ClassMethod\MockeryCreateMockToProphizeRector::class;
    }
}
