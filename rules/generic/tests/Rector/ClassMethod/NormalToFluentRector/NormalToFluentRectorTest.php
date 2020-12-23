<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\ClassMethod\NormalToFluentRector;

use Iterator;
use _PhpScoper0a2ac50786fa\Rector\Generic\Rector\ClassMethod\NormalToFluentRector;
use _PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\ClassMethod\NormalToFluentRector\Source\FluentInterfaceClass;
use _PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\NormalToFluent;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class NormalToFluentRectorTest extends \_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a2ac50786fa\Rector\Generic\Rector\ClassMethod\NormalToFluentRector::class => [\_PhpScoper0a2ac50786fa\Rector\Generic\Rector\ClassMethod\NormalToFluentRector::CALLS_TO_FLUENT => [new \_PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\NormalToFluent(\_PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\ClassMethod\NormalToFluentRector\Source\FluentInterfaceClass::class, ['someFunction', 'otherFunction', 'joinThisAsWell'])]]];
    }
}
