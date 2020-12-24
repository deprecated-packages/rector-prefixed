<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\StaticCall\SwapClassMethodArgumentsRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\StaticCall\SwapClassMethodArgumentsRector;
use _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\StaticCall\SwapClassMethodArgumentsRector\Fixture\SomeClass;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\SwapClassMethodArguments;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class SwapClassMethodArgumentsRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\StaticCall\SwapClassMethodArgumentsRector::class => [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\StaticCall\SwapClassMethodArgumentsRector::ARGUMENT_SWAPS => [new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\SwapClassMethodArguments(\_PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\StaticCall\SwapClassMethodArgumentsRector\Fixture\SomeClass::class, 'run', [1, 0])]]];
    }
}
