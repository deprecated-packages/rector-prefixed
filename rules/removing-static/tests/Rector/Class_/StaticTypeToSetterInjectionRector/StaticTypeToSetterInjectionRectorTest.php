<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\RemovingStatic\Tests\Rector\Class_\StaticTypeToSetterInjectionRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\RemovingStatic\Rector\Class_\StaticTypeToSetterInjectionRector;
use _PhpScopere8e811afab72\Rector\RemovingStatic\Tests\Rector\Class_\StaticTypeToSetterInjectionRector\Source\GenericEntityFactory;
use _PhpScopere8e811afab72\Rector\RemovingStatic\Tests\Rector\Class_\StaticTypeToSetterInjectionRector\Source\GenericEntityFactoryWithInterface;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class StaticTypeToSetterInjectionRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\RemovingStatic\Rector\Class_\StaticTypeToSetterInjectionRector::class => [\_PhpScopere8e811afab72\Rector\RemovingStatic\Rector\Class_\StaticTypeToSetterInjectionRector::STATIC_TYPES => [
            \_PhpScopere8e811afab72\Rector\RemovingStatic\Tests\Rector\Class_\StaticTypeToSetterInjectionRector\Source\GenericEntityFactory::class,
            // with adding a parent interface to the class
            'ParentSetterEnforcingInterface' => \_PhpScopere8e811afab72\Rector\RemovingStatic\Tests\Rector\Class_\StaticTypeToSetterInjectionRector\Source\GenericEntityFactoryWithInterface::class,
        ]]];
    }
}
