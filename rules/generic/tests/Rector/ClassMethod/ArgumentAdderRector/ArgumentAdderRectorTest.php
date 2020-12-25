<?php

declare (strict_types=1);
namespace Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector;

use Iterator;
use Rector\Generic\Rector\ClassMethod\ArgumentAdderRector;
use Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeContainerBuilder;
use Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeParentClient;
use Rector\Generic\ValueObject\ArgumentAdder;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
final class ArgumentAdderRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class => [\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => [
            // covers https://github.com/rectorphp/rector/issues/4267
            new \Rector\Generic\ValueObject\ArgumentAdder(\Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeContainerBuilder::class, 'sendResetLinkResponse', 0, 'request', null, '_PhpScoper17db12703726\\Illuminate\\Http\\Illuminate\\Http'),
            new \Rector\Generic\ValueObject\ArgumentAdder(\Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeContainerBuilder::class, 'compile', 0, 'isCompiled', \false),
            new \Rector\Generic\ValueObject\ArgumentAdder(\Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeContainerBuilder::class, 'addCompilerPass', 2, 'priority', 0, 'int'),
            // scoped
            new \Rector\Generic\ValueObject\ArgumentAdder(\Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeParentClient::class, 'submit', 2, 'serverParameters', [], 'array', \Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_PARENT_CALL),
            new \Rector\Generic\ValueObject\ArgumentAdder(\Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeParentClient::class, 'submit', 2, 'serverParameters', [], 'array', \Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_CLASS_METHOD),
        ]]];
    }
}
