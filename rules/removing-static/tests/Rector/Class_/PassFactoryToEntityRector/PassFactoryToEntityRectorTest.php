<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\RemovingStatic\Rector\Class_\NewUniqueObjectToEntityFactoryRector;
use _PhpScoperb75b35f52b74\Rector\RemovingStatic\Rector\Class_\PassFactoryToUniqueObjectRector;
use _PhpScoperb75b35f52b74\Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Source\TurnMeToService;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\EasyTesting\StaticFixtureSplitter;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class PassFactoryToEntityRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
        $expectedFactoryFilePath = \_PhpScoperb75b35f52b74\Symplify\EasyTesting\StaticFixtureSplitter::getTemporaryPath() . '/AnotherClassWithMoreArgumentsFactory.php';
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
        $typesToServices = [\_PhpScoperb75b35f52b74\Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Source\TurnMeToService::class];
        return [\_PhpScoperb75b35f52b74\Rector\RemovingStatic\Rector\Class_\PassFactoryToUniqueObjectRector::class => [\_PhpScoperb75b35f52b74\Rector\RemovingStatic\Rector\Class_\PassFactoryToUniqueObjectRector::TYPES_TO_SERVICES => $typesToServices], \_PhpScoperb75b35f52b74\Rector\RemovingStatic\Rector\Class_\NewUniqueObjectToEntityFactoryRector::class => [\_PhpScoperb75b35f52b74\Rector\RemovingStatic\Rector\Class_\NewUniqueObjectToEntityFactoryRector::TYPES_TO_SERVICES => $typesToServices]];
    }
}
