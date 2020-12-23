<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\StaticCall\SwapClassMethodArgumentsRector;

use Iterator;
use _PhpScoper0a2ac50786fa\Rector\Generic\Rector\StaticCall\SwapClassMethodArgumentsRector;
use _PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\StaticCall\SwapClassMethodArgumentsRector\Fixture\SomeClass;
use _PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\SwapClassMethodArguments;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class SwapClassMethodArgumentsRectorTest extends \_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper0a2ac50786fa\Rector\Generic\Rector\StaticCall\SwapClassMethodArgumentsRector::class => [\_PhpScoper0a2ac50786fa\Rector\Generic\Rector\StaticCall\SwapClassMethodArgumentsRector::ARGUMENT_SWAPS => [new \_PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\SwapClassMethodArguments(\_PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\StaticCall\SwapClassMethodArgumentsRector\Fixture\SomeClass::class, 'run', [1, 0])]]];
    }
}
