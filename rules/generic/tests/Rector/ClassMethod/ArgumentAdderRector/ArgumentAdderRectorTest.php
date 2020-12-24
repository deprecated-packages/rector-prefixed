<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeContainerBuilder;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeParentClient;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\ArgumentAdder;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class ArgumentAdderRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class => [\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => [
            // covers https://github.com/rectorphp/rector/issues/4267
            new \_PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\ArgumentAdder(\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeContainerBuilder::class, 'sendResetLinkResponse', 0, 'request', null, '_PhpScoper2a4e7ab1ecbc\\Illuminate\\Http\\Illuminate\\Http'),
            new \_PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\ArgumentAdder(\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeContainerBuilder::class, 'compile', 0, 'isCompiled', \false),
            new \_PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\ArgumentAdder(\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeContainerBuilder::class, 'addCompilerPass', 2, 'priority', 0, 'int'),
            // scoped
            new \_PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\ArgumentAdder(\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeParentClient::class, 'submit', 2, 'serverParameters', [], 'array', \_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_PARENT_CALL),
            new \_PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\ArgumentAdder(\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeParentClient::class, 'submit', 2, 'serverParameters', [], 'array', \_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_CLASS_METHOD),
        ]]];
    }
}
