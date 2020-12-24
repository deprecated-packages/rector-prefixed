<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\StaticCall\SwapClassMethodArgumentsRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Generic\Rector\StaticCall\SwapClassMethodArgumentsRector;
use _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\StaticCall\SwapClassMethodArgumentsRector\Fixture\SomeClass;
use _PhpScoper0a6b37af0871\Rector\Generic\ValueObject\SwapClassMethodArguments;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class SwapClassMethodArgumentsRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\StaticCall\SwapClassMethodArgumentsRector::class => [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\StaticCall\SwapClassMethodArgumentsRector::ARGUMENT_SWAPS => [new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\SwapClassMethodArguments(\_PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\StaticCall\SwapClassMethodArgumentsRector\Fixture\SomeClass::class, 'run', [1, 0])]]];
    }
}
