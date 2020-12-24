<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Rector\RemovingStatic\Rector\Class_\NewUniqueObjectToEntityFactoryRector;
use _PhpScoper2a4e7ab1ecbc\Rector\RemovingStatic\Rector\Class_\PassFactoryToUniqueObjectRector;
use _PhpScoper2a4e7ab1ecbc\Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Source\TurnMeToService;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Symplify\EasyTesting\StaticFixtureSplitter;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class PassFactoryToEntityRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
        $expectedFactoryFilePath = \_PhpScoper2a4e7ab1ecbc\Symplify\EasyTesting\StaticFixtureSplitter::getTemporaryPath() . '/AnotherClassWithMoreArgumentsFactory.php';
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
        $typesToServices = [\_PhpScoper2a4e7ab1ecbc\Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Source\TurnMeToService::class];
        return [\_PhpScoper2a4e7ab1ecbc\Rector\RemovingStatic\Rector\Class_\PassFactoryToUniqueObjectRector::class => [\_PhpScoper2a4e7ab1ecbc\Rector\RemovingStatic\Rector\Class_\PassFactoryToUniqueObjectRector::TYPES_TO_SERVICES => $typesToServices], \_PhpScoper2a4e7ab1ecbc\Rector\RemovingStatic\Rector\Class_\NewUniqueObjectToEntityFactoryRector::class => [\_PhpScoper2a4e7ab1ecbc\Rector\RemovingStatic\Rector\Class_\NewUniqueObjectToEntityFactoryRector::TYPES_TO_SERVICES => $typesToServices]];
    }
}
