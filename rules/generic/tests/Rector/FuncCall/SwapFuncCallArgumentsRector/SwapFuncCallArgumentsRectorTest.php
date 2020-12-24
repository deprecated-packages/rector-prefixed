<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\FuncCall\SwapFuncCallArgumentsRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Generic\Rector\FuncCall\SwapFuncCallArgumentsRector;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\SwapFuncCallArguments;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class SwapFuncCallArgumentsRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\_PhpScopere8e811afab72\Rector\Generic\Rector\FuncCall\SwapFuncCallArgumentsRector::class => [\_PhpScopere8e811afab72\Rector\Generic\Rector\FuncCall\SwapFuncCallArgumentsRector::FUNCTION_ARGUMENT_SWAPS => [new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\SwapFuncCallArguments('some_function', [1, 0])]]];
    }
}
