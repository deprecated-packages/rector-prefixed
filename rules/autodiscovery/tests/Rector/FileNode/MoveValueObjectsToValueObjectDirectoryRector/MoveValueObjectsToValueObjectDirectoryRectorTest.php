<?php

declare (strict_types=1);
namespace Rector\Autodiscovery\Tests\Rector\FileNode\MoveValueObjectsToValueObjectDirectoryRector;

use Iterator;
use Rector\Autodiscovery\Rector\FileNode\MoveValueObjectsToValueObjectDirectoryRector;
use Rector\Autodiscovery\Tests\Rector\FileNode\MoveValueObjectsToValueObjectDirectoryRector\Source\ObviousValueObjectInterface;
use Rector\FileSystemRector\ValueObject\AddedFileWithContent;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
use Symplify\SmartFileSystem\SmartFileSystem;
final class MoveValueObjectsToValueObjectDirectoryRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\Symplify\SmartFileSystem\SmartFileInfo $fixtureFileInfo, ?\Rector\FileSystemRector\ValueObject\AddedFileWithContent $expectedAddedFileWithContent) : void
    {
        $this->doTestFileInfo($fixtureFileInfo);
        if ($expectedAddedFileWithContent !== null) {
            $this->assertFileWithContentWasAdded($expectedAddedFileWithContent);
        } else {
            $this->assertFileWasNotChanged($this->originalTempFileInfo);
        }
    }
    public function provideData() : \Iterator
    {
        $smartFileSystem = new \Symplify\SmartFileSystem\SmartFileSystem();
        (yield [new \Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/Repository/PrimitiveValueObject.php'), new \Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/Source/ValueObject/PrimitiveValueObject.php', $smartFileSystem->readFile(__DIR__ . '/Expected/ValueObject/PrimitiveValueObject.php'))]);
        // type
        (yield [new \Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/Command/SomeName.php'), new \Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/Source/ValueObject/SomeName.php', $smartFileSystem->readFile(__DIR__ . '/Expected/ValueObject/SomeName.php'))]);
        // suffix
        (yield [new \Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/Command/MeSearch.php'), new \Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/Source/ValueObject/MeSearch.php', $smartFileSystem->readFile(__DIR__ . '/Expected/ValueObject/MeSearch.php'))]);
        // skip known service types
        (yield [new \Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/Utils/SomeSuffixedTest.php.inc'), null]);
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\Rector\Autodiscovery\Rector\FileNode\MoveValueObjectsToValueObjectDirectoryRector::class => [\Rector\Autodiscovery\Rector\FileNode\MoveValueObjectsToValueObjectDirectoryRector::TYPES => [\Rector\Autodiscovery\Tests\Rector\FileNode\MoveValueObjectsToValueObjectDirectoryRector\Source\ObviousValueObjectInterface::class], \Rector\Autodiscovery\Rector\FileNode\MoveValueObjectsToValueObjectDirectoryRector::SUFFIXES => ['Search'], \Rector\Autodiscovery\Rector\FileNode\MoveValueObjectsToValueObjectDirectoryRector::ENABLE_VALUE_OBJECT_GUESSING => \true]];
    }
}
