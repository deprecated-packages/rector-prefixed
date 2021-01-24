<?php

declare (strict_types=1);
namespace Rector\Generic\Tests\Rector\FuncCall\RemoveIniGetSetFuncCallRector;

use Iterator;
use Rector\Generic\Rector\FuncCall\RemoveIniGetSetFuncCallRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use SplFileInfo;
use RectorPrefix20210124\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveIniGetSetFuncCallRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210124\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Generic\Rector\FuncCall\RemoveIniGetSetFuncCallRector::class => [\Rector\Generic\Rector\FuncCall\RemoveIniGetSetFuncCallRector::KEYS_TO_REMOVE => ['y2k_compliance', 'safe_mode', 'magic_quotes_runtime']]];
    }
}
