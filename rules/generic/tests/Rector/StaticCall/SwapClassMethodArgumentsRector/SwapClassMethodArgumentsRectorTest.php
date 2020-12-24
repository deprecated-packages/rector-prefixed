<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\StaticCall\SwapClassMethodArgumentsRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Generic\Rector\StaticCall\SwapClassMethodArgumentsRector;
use _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\StaticCall\SwapClassMethodArgumentsRector\Fixture\SomeClass;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\SwapClassMethodArguments;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class SwapClassMethodArgumentsRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Generic\Rector\StaticCall\SwapClassMethodArgumentsRector::class => [\_PhpScopere8e811afab72\Rector\Generic\Rector\StaticCall\SwapClassMethodArgumentsRector::ARGUMENT_SWAPS => [new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\SwapClassMethodArguments(\_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\StaticCall\SwapClassMethodArgumentsRector\Fixture\SomeClass::class, 'run', [1, 0])]]];
    }
}
