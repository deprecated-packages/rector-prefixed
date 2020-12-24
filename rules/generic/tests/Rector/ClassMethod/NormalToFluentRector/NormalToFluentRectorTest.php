<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassMethod\NormalToFluentRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\NormalToFluentRector;
use _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassMethod\NormalToFluentRector\Source\FluentInterfaceClass;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\NormalToFluent;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class NormalToFluentRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\NormalToFluentRector::class => [\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\NormalToFluentRector::CALLS_TO_FLUENT => [new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\NormalToFluent(\_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassMethod\NormalToFluentRector\Source\FluentInterfaceClass::class, ['someFunction', 'otherFunction', 'joinThisAsWell'])]]];
    }
}
