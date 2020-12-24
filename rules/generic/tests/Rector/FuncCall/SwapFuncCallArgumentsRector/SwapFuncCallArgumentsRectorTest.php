<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\FuncCall\SwapFuncCallArgumentsRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\FuncCall\SwapFuncCallArgumentsRector;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\SwapFuncCallArguments;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class SwapFuncCallArgumentsRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\FuncCall\SwapFuncCallArgumentsRector::class => [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\FuncCall\SwapFuncCallArgumentsRector::FUNCTION_ARGUMENT_SWAPS => [new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\SwapFuncCallArguments('some_function', [1, 0])]]];
    }
}
