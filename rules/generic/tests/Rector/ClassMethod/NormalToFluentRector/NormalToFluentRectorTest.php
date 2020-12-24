<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\ClassMethod\NormalToFluentRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\NormalToFluentRector;
use _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\ClassMethod\NormalToFluentRector\Source\FluentInterfaceClass;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\NormalToFluent;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class NormalToFluentRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\NormalToFluentRector::class => [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\NormalToFluentRector::CALLS_TO_FLUENT => [new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\NormalToFluent(\_PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\ClassMethod\NormalToFluentRector\Source\FluentInterfaceClass::class, ['someFunction', 'otherFunction', 'joinThisAsWell'])]]];
    }
}
