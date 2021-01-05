<?php

declare (strict_types=1);
namespace Rector\Generic\Tests\Rector\FuncCall\SwapFuncCallArgumentsRector;

use Iterator;
use Rector\Generic\Rector\FuncCall\SwapFuncCallArgumentsRector;
use Rector\Generic\ValueObject\SwapFuncCallArguments;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210105\Symplify\SmartFileSystem\SmartFileInfo;
final class SwapFuncCallArgumentsRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210105\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Generic\Rector\FuncCall\SwapFuncCallArgumentsRector::class => [\Rector\Generic\Rector\FuncCall\SwapFuncCallArgumentsRector::FUNCTION_ARGUMENT_SWAPS => [new \Rector\Generic\ValueObject\SwapFuncCallArguments('some_function', [1, 0])]]];
    }
}
