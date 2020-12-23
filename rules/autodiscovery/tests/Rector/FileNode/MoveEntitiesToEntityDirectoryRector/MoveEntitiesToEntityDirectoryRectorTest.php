<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Autodiscovery\Tests\Rector\FileNode\MoveEntitiesToEntityDirectoryRector;

use Iterator;
use _PhpScoper0a2ac50786fa\Rector\Autodiscovery\Rector\FileNode\MoveEntitiesToEntityDirectoryRector;
use _PhpScoper0a2ac50786fa\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoper0a2ac50786fa\Rector\FileSystemRector\ValueObject\AddedFileWithContent;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileSystem;
final class MoveEntitiesToEntityDirectoryRectorTest extends \_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $originalFileInfo, \_PhpScoper0a2ac50786fa\Rector\FileSystemRector\ValueObject\AddedFileWithContent $expectedAddedFileWithContent) : void
    {
        $this->doTestFileInfo($originalFileInfo);
        $this->assertFileWithContentWasAdded($expectedAddedFileWithContent);
    }
    public function provideData() : \Iterator
    {
        $smartFileSystem = new \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileSystem();
        (yield [new \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/Controller/RandomEntity.php'), new \_PhpScoper0a2ac50786fa\Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/Source/Entity/RandomEntity.php', $smartFileSystem->readFile(__DIR__ . '/Expected/ExpectedRandomEntity.php'))]);
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoper0a2ac50786fa\Rector\Autodiscovery\Rector\FileNode\MoveEntitiesToEntityDirectoryRector::class;
    }
    protected function getPhpVersion() : int
    {
        return \_PhpScoper0a2ac50786fa\Rector\Core\ValueObject\PhpVersionFeature::TYPED_PROPERTIES - 1;
    }
}
