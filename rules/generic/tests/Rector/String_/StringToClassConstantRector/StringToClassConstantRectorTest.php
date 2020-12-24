<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\String_\StringToClassConstantRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Generic\Rector\String_\StringToClassConstantRector;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\StringToClassConstant;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class StringToClassConstantRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Generic\Rector\String_\StringToClassConstantRector::class => [\_PhpScopere8e811afab72\Rector\Generic\Rector\String_\StringToClassConstantRector::STRINGS_TO_CLASS_CONSTANTS => [new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\StringToClassConstant('compiler.post_dump', '_PhpScopere8e811afab72\\Yet\\AnotherClass', 'CONSTANT'), new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\StringToClassConstant('compiler.to_class', '_PhpScopere8e811afab72\\Yet\\AnotherClass', 'class')]]];
    }
}
