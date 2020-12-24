<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\RemovingStatic\Tests\Rector\Class_\PHPUnitStaticToKernelTestCaseGetRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\RemovingStatic\Rector\Class_\PHPUnitStaticToKernelTestCaseGetRector;
use _PhpScopere8e811afab72\Rector\RemovingStatic\Tests\Rector\Class_\PHPUnitStaticToKernelTestCaseGetRector\Source\ClassWithStaticMethods;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class PHPUnitStaticToKernelTestCaseGetRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\RemovingStatic\Rector\Class_\PHPUnitStaticToKernelTestCaseGetRector::class => [\_PhpScopere8e811afab72\Rector\RemovingStatic\Rector\Class_\PHPUnitStaticToKernelTestCaseGetRector::STATIC_CLASS_TYPES => [\_PhpScopere8e811afab72\Rector\RemovingStatic\Tests\Rector\Class_\PHPUnitStaticToKernelTestCaseGetRector\Source\ClassWithStaticMethods::class]]];
    }
}
