<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\String_\StringToClassConstantRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Generic\Rector\String_\StringToClassConstantRector;
use _PhpScoper0a6b37af0871\Rector\Generic\ValueObject\StringToClassConstant;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class StringToClassConstantRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\String_\StringToClassConstantRector::class => [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\String_\StringToClassConstantRector::STRINGS_TO_CLASS_CONSTANTS => [new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\StringToClassConstant('compiler.post_dump', '_PhpScoper0a6b37af0871\\Yet\\AnotherClass', 'CONSTANT'), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\StringToClassConstant('compiler.to_class', '_PhpScoper0a6b37af0871\\Yet\\AnotherClass', 'class')]]];
    }
}
