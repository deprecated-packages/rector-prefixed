<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\RemovingStatic\Rector\Class_\NewUniqueObjectToEntityFactoryRector;
use _PhpScopere8e811afab72\Rector\RemovingStatic\Rector\Class_\PassFactoryToUniqueObjectRector;
use _PhpScopere8e811afab72\Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Source\TurnMeToService;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\EasyTesting\StaticFixtureSplitter;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class PassFactoryToEntityRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
        $expectedFactoryFilePath = \_PhpScopere8e811afab72\Symplify\EasyTesting\StaticFixtureSplitter::getTemporaryPath() . '/AnotherClassWithMoreArgumentsFactory.php';
        $this->assertFileExists($expectedFactoryFilePath);
        $this->assertFileEquals(__DIR__ . '/Source/ExpectedAnotherClassWithMoreArgumentsFactory.php', $expectedFactoryFilePath);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureWithMultipleArguments');
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        $typesToServices = [\_PhpScopere8e811afab72\Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Source\TurnMeToService::class];
        return [\_PhpScopere8e811afab72\Rector\RemovingStatic\Rector\Class_\PassFactoryToUniqueObjectRector::class => [\_PhpScopere8e811afab72\Rector\RemovingStatic\Rector\Class_\PassFactoryToUniqueObjectRector::TYPES_TO_SERVICES => $typesToServices], \_PhpScopere8e811afab72\Rector\RemovingStatic\Rector\Class_\NewUniqueObjectToEntityFactoryRector::class => [\_PhpScopere8e811afab72\Rector\RemovingStatic\Rector\Class_\NewUniqueObjectToEntityFactoryRector::TYPES_TO_SERVICES => $typesToServices]];
    }
}
