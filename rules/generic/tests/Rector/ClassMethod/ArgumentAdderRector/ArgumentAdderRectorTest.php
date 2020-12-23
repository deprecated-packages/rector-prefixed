<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector;

use Iterator;
use _PhpScoper0a2ac50786fa\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector;
use _PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeContainerBuilder;
use _PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeParentClient;
use _PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\ArgumentAdder;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class ArgumentAdderRectorTest extends \_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a2ac50786fa\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class => [\_PhpScoper0a2ac50786fa\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => [
            // covers https://github.com/rectorphp/rector/issues/4267
            new \_PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\ArgumentAdder(\_PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeContainerBuilder::class, 'sendResetLinkResponse', 0, 'request', null, '_PhpScoper0a2ac50786fa\\Illuminate\\Http\\Illuminate\\Http'),
            new \_PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\ArgumentAdder(\_PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeContainerBuilder::class, 'compile', 0, 'isCompiled', \false),
            new \_PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\ArgumentAdder(\_PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeContainerBuilder::class, 'addCompilerPass', 2, 'priority', 0, 'int'),
            // scoped
            new \_PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\ArgumentAdder(\_PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeParentClient::class, 'submit', 2, 'serverParameters', [], 'array', \_PhpScoper0a2ac50786fa\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_PARENT_CALL),
            new \_PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\ArgumentAdder(\_PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeParentClient::class, 'submit', 2, 'serverParameters', [], 'array', \_PhpScoper0a2ac50786fa\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_CLASS_METHOD),
        ]]];
    }
}
