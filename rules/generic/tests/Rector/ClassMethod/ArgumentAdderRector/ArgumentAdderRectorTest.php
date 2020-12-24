<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector;
use _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeContainerBuilder;
use _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeParentClient;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class ArgumentAdderRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class => [\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => [
            // covers https://github.com/rectorphp/rector/issues/4267
            new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder(\_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeContainerBuilder::class, 'sendResetLinkResponse', 0, 'request', null, '_PhpScopere8e811afab72\\Illuminate\\Http\\Illuminate\\Http'),
            new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder(\_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeContainerBuilder::class, 'compile', 0, 'isCompiled', \false),
            new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder(\_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeContainerBuilder::class, 'addCompilerPass', 2, 'priority', 0, 'int'),
            // scoped
            new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder(\_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeParentClient::class, 'submit', 2, 'serverParameters', [], 'array', \_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_PARENT_CALL),
            new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder(\_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeParentClient::class, 'submit', 2, 'serverParameters', [], 'array', \_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_CLASS_METHOD),
        ]]];
    }
}
