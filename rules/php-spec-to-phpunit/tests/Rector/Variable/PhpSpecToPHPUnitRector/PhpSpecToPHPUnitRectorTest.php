<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\Tests\Rector\Variable\PhpSpecToPHPUnitRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\Rector\Class_\AddMockPropertiesRector;
use _PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\Rector\Class_\PhpSpecClassToPHPUnitClassRector;
use _PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\Rector\ClassMethod\PhpSpecMethodToPHPUnitMethodRector;
use _PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\Rector\MethodCall\PhpSpecMocksToPHPUnitMocksRector;
use _PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\Rector\MethodCall\PhpSpecPromisesToPHPUnitAssertRector;
use _PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\Rector\Variable\MockVariableToPropertyFetchRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class PhpSpecToPHPUnitRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [
            # 1. first convert mocks
            \_PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\Rector\MethodCall\PhpSpecMocksToPHPUnitMocksRector::class => [],
            \_PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\Rector\MethodCall\PhpSpecPromisesToPHPUnitAssertRector::class => [],
            \_PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\Rector\ClassMethod\PhpSpecMethodToPHPUnitMethodRector::class => [],
            \_PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\Rector\Class_\PhpSpecClassToPHPUnitClassRector::class => [],
            \_PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\Rector\Class_\AddMockPropertiesRector::class => [],
            \_PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\Rector\Variable\MockVariableToPropertyFetchRector::class => [],
        ];
    }
}
