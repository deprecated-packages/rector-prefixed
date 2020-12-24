<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\RemovingStatic\Tests\Rector\Class_\SingleStaticServiceToDynamicRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\RemovingStatic\Rector\Class_\SingleStaticServiceToDynamicRector;
use _PhpScopere8e811afab72\Rector\RemovingStatic\Tests\Rector\Class_\SingleStaticServiceToDynamicRector\Source\ClassWithStaticProperties;
use _PhpScopere8e811afab72\Rector\RemovingStatic\Tests\Rector\Class_\SingleStaticServiceToDynamicRector\Source\FirstStaticClass;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class SingleStaticServiceToDynamicRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\RemovingStatic\Rector\Class_\SingleStaticServiceToDynamicRector::class => [\_PhpScopere8e811afab72\Rector\RemovingStatic\Rector\Class_\SingleStaticServiceToDynamicRector::CLASS_TYPES => ['_PhpScopere8e811afab72\\Rector\\RemovingStatic\\Tests\\Rector\\Class_\\SingleStaticServiceToDynamicRector\\Fixture\\Fixture', '_PhpScopere8e811afab72\\Rector\\RemovingStatic\\Tests\\Rector\\Class_\\SingleStaticServiceToDynamicRector\\Fixture\\StaticProperties', \_PhpScopere8e811afab72\Rector\RemovingStatic\Tests\Rector\Class_\SingleStaticServiceToDynamicRector\Source\FirstStaticClass::class, \_PhpScopere8e811afab72\Rector\RemovingStatic\Tests\Rector\Class_\SingleStaticServiceToDynamicRector\Source\ClassWithStaticProperties::class]]];
    }
}
