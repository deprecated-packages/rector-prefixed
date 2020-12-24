<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\ClassMethod\NormalToFluentRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\NormalToFluentRector;
use _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\ClassMethod\NormalToFluentRector\Source\FluentInterfaceClass;
use _PhpScoper0a6b37af0871\Rector\Generic\ValueObject\NormalToFluent;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class NormalToFluentRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\NormalToFluentRector::class => [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\NormalToFluentRector::CALLS_TO_FLUENT => [new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\NormalToFluent(\_PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\ClassMethod\NormalToFluentRector\Source\FluentInterfaceClass::class, ['someFunction', 'otherFunction', 'joinThisAsWell'])]]];
    }
}
