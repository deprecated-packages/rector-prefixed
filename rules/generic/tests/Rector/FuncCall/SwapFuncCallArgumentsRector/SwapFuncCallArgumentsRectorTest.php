<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\FuncCall\SwapFuncCallArgumentsRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Generic\Rector\FuncCall\SwapFuncCallArgumentsRector;
use _PhpScoper0a6b37af0871\Rector\Generic\ValueObject\SwapFuncCallArguments;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class SwapFuncCallArgumentsRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\FuncCall\SwapFuncCallArgumentsRector::class => [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\FuncCall\SwapFuncCallArgumentsRector::FUNCTION_ARGUMENT_SWAPS => [new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\SwapFuncCallArguments('some_function', [1, 0])]]];
    }
}
