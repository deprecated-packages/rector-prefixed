<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Autodiscovery\Tests\Rector\FileNode\MoveValueObjectsToValueObjectDirectoryRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Autodiscovery\Rector\FileNode\MoveValueObjectsToValueObjectDirectoryRector;
use _PhpScopere8e811afab72\Rector\Autodiscovery\Tests\Rector\FileNode\MoveValueObjectsToValueObjectDirectoryRector\Source\ObviousValueObjectInterface;
use _PhpScopere8e811afab72\Rector\FileSystemRector\ValueObject\AddedFileWithContent;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem;
final class MoveValueObjectsToValueObjectDirectoryRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fixtureFileInfo, ?\_PhpScopere8e811afab72\Rector\FileSystemRector\ValueObject\AddedFileWithContent $expectedAddedFileWithContent) : void
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
        $smartFileSystem = new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem();
        (yield [new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/Repository/PrimitiveValueObject.php'), new \_PhpScopere8e811afab72\Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/Source/ValueObject/PrimitiveValueObject.php', $smartFileSystem->readFile(__DIR__ . '/Expected/ValueObject/PrimitiveValueObject.php'))]);
        // type
        (yield [new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/Command/SomeName.php'), new \_PhpScopere8e811afab72\Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/Source/ValueObject/SomeName.php', $smartFileSystem->readFile(__DIR__ . '/Expected/ValueObject/SomeName.php'))]);
        // suffix
        (yield [new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/Command/MeSearch.php'), new \_PhpScopere8e811afab72\Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/Source/ValueObject/MeSearch.php', $smartFileSystem->readFile(__DIR__ . '/Expected/ValueObject/MeSearch.php'))]);
        // skip known service types
        (yield [new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/Utils/SomeSuffixedTest.php.inc'), null]);
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\_PhpScopere8e811afab72\Rector\Autodiscovery\Rector\FileNode\MoveValueObjectsToValueObjectDirectoryRector::class => [\_PhpScopere8e811afab72\Rector\Autodiscovery\Rector\FileNode\MoveValueObjectsToValueObjectDirectoryRector::TYPES => [\_PhpScopere8e811afab72\Rector\Autodiscovery\Tests\Rector\FileNode\MoveValueObjectsToValueObjectDirectoryRector\Source\ObviousValueObjectInterface::class], \_PhpScopere8e811afab72\Rector\Autodiscovery\Rector\FileNode\MoveValueObjectsToValueObjectDirectoryRector::SUFFIXES => ['Search'], \_PhpScopere8e811afab72\Rector\Autodiscovery\Rector\FileNode\MoveValueObjectsToValueObjectDirectoryRector::ENABLE_VALUE_OBJECT_GUESSING => \true]];
    }
}
