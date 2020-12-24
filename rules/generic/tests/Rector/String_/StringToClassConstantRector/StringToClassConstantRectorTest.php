<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\String_\StringToClassConstantRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\String_\StringToClassConstantRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\StringToClassConstant;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class StringToClassConstantRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\String_\StringToClassConstantRector::class => [\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\String_\StringToClassConstantRector::STRINGS_TO_CLASS_CONSTANTS => [new \_PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\StringToClassConstant('compiler.post_dump', '_PhpScoper2a4e7ab1ecbc\\Yet\\AnotherClass', 'CONSTANT'), new \_PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\StringToClassConstant('compiler.to_class', '_PhpScoper2a4e7ab1ecbc\\Yet\\AnotherClass', 'class')]]];
    }
}
