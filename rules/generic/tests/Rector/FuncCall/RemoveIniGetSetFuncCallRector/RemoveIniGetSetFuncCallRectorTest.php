<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\FuncCall\RemoveIniGetSetFuncCallRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\FuncCall\RemoveIniGetSetFuncCallRector;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use SplFileInfo;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveIniGetSetFuncCallRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\FuncCall\RemoveIniGetSetFuncCallRector::class => [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\FuncCall\RemoveIniGetSetFuncCallRector::KEYS_TO_REMOVE => ['y2k_compliance', 'safe_mode', 'magic_quotes_runtime']]];
    }
}
