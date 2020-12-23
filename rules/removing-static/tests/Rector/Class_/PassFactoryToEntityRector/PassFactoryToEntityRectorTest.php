<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector;

use Iterator;
use _PhpScoper0a2ac50786fa\Rector\RemovingStatic\Rector\Class_\NewUniqueObjectToEntityFactoryRector;
use _PhpScoper0a2ac50786fa\Rector\RemovingStatic\Rector\Class_\PassFactoryToUniqueObjectRector;
use _PhpScoper0a2ac50786fa\Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Source\TurnMeToService;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a2ac50786fa\Symplify\EasyTesting\StaticFixtureSplitter;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class PassFactoryToEntityRectorTest extends \_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
        $expectedFactoryFilePath = \_PhpScoper0a2ac50786fa\Symplify\EasyTesting\StaticFixtureSplitter::getTemporaryPath() . '/AnotherClassWithMoreArgumentsFactory.php';
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
        $typesToServices = [\_PhpScoper0a2ac50786fa\Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Source\TurnMeToService::class];
        return [\_PhpScoper0a2ac50786fa\Rector\RemovingStatic\Rector\Class_\PassFactoryToUniqueObjectRector::class => [\_PhpScoper0a2ac50786fa\Rector\RemovingStatic\Rector\Class_\PassFactoryToUniqueObjectRector::TYPES_TO_SERVICES => $typesToServices], \_PhpScoper0a2ac50786fa\Rector\RemovingStatic\Rector\Class_\NewUniqueObjectToEntityFactoryRector::class => [\_PhpScoper0a2ac50786fa\Rector\RemovingStatic\Rector\Class_\NewUniqueObjectToEntityFactoryRector::TYPES_TO_SERVICES => $typesToServices]];
    }
}
