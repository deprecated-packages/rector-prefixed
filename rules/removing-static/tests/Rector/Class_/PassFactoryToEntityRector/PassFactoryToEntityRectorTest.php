<?php

declare (strict_types=1);
namespace Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector;

use Iterator;
use Rector\RemovingStatic\Rector\Class_\NewUniqueObjectToEntityFactoryRector;
use Rector\RemovingStatic\Rector\Class_\PassFactoryToUniqueObjectRector;
use Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Source\TurnMeToService;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210205\Symplify\EasyTesting\StaticFixtureSplitter;
use RectorPrefix20210205\Symplify\SmartFileSystem\SmartFileInfo;
final class PassFactoryToEntityRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210205\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
        $expectedFactoryFilePath = \RectorPrefix20210205\Symplify\EasyTesting\StaticFixtureSplitter::getTemporaryPath() . '/AnotherClassWithMoreArgumentsFactory.php';
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
        $typesToServices = [\Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Source\TurnMeToService::class];
        return [\Rector\RemovingStatic\Rector\Class_\PassFactoryToUniqueObjectRector::class => [\Rector\RemovingStatic\Rector\Class_\PassFactoryToUniqueObjectRector::TYPES_TO_SERVICES => $typesToServices], \Rector\RemovingStatic\Rector\Class_\NewUniqueObjectToEntityFactoryRector::class => [\Rector\RemovingStatic\Rector\Class_\NewUniqueObjectToEntityFactoryRector::TYPES_TO_SERVICES => $typesToServices]];
    }
}
