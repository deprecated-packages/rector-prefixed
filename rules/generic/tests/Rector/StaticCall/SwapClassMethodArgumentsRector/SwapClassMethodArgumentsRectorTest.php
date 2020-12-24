<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\StaticCall\SwapClassMethodArgumentsRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\StaticCall\SwapClassMethodArgumentsRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\StaticCall\SwapClassMethodArgumentsRector\Fixture\SomeClass;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\SwapClassMethodArguments;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class SwapClassMethodArgumentsRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\StaticCall\SwapClassMethodArgumentsRector::class => [\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\StaticCall\SwapClassMethodArgumentsRector::ARGUMENT_SWAPS => [new \_PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\SwapClassMethodArguments(\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\StaticCall\SwapClassMethodArgumentsRector\Fixture\SomeClass::class, 'run', [1, 0])]]];
    }
}
