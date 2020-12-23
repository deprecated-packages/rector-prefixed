<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Autodiscovery\Tests\Rector\FileNode\MoveValueObjectsToValueObjectDirectoryRector;

use Iterator;
use _PhpScoper0a2ac50786fa\Rector\Autodiscovery\Rector\FileNode\MoveValueObjectsToValueObjectDirectoryRector;
use _PhpScoper0a2ac50786fa\Rector\Autodiscovery\Tests\Rector\FileNode\MoveValueObjectsToValueObjectDirectoryRector\Source\ObviousValueObjectInterface;
use _PhpScoper0a2ac50786fa\Rector\FileSystemRector\ValueObject\AddedFileWithContent;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileSystem;
final class MoveValueObjectsToValueObjectDirectoryRectorTest extends \_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $fixtureFileInfo, ?\_PhpScoper0a2ac50786fa\Rector\FileSystemRector\ValueObject\AddedFileWithContent $expectedAddedFileWithContent) : void
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
        $smartFileSystem = new \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileSystem();
        (yield [new \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/Repository/PrimitiveValueObject.php'), new \_PhpScoper0a2ac50786fa\Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/Source/ValueObject/PrimitiveValueObject.php', $smartFileSystem->readFile(__DIR__ . '/Expected/ValueObject/PrimitiveValueObject.php'))]);
        // type
        (yield [new \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/Command/SomeName.php'), new \_PhpScoper0a2ac50786fa\Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/Source/ValueObject/SomeName.php', $smartFileSystem->readFile(__DIR__ . '/Expected/ValueObject/SomeName.php'))]);
        // suffix
        (yield [new \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/Command/MeSearch.php'), new \_PhpScoper0a2ac50786fa\Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/Source/ValueObject/MeSearch.php', $smartFileSystem->readFile(__DIR__ . '/Expected/ValueObject/MeSearch.php'))]);
        // skip known service types
        (yield [new \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/Utils/SomeSuffixedTest.php.inc'), null]);
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\_PhpScoper0a2ac50786fa\Rector\Autodiscovery\Rector\FileNode\MoveValueObjectsToValueObjectDirectoryRector::class => [\_PhpScoper0a2ac50786fa\Rector\Autodiscovery\Rector\FileNode\MoveValueObjectsToValueObjectDirectoryRector::TYPES => [\_PhpScoper0a2ac50786fa\Rector\Autodiscovery\Tests\Rector\FileNode\MoveValueObjectsToValueObjectDirectoryRector\Source\ObviousValueObjectInterface::class], \_PhpScoper0a2ac50786fa\Rector\Autodiscovery\Rector\FileNode\MoveValueObjectsToValueObjectDirectoryRector::SUFFIXES => ['Search'], \_PhpScoper0a2ac50786fa\Rector\Autodiscovery\Rector\FileNode\MoveValueObjectsToValueObjectDirectoryRector::ENABLE_VALUE_OBJECT_GUESSING => \true]];
    }
}
