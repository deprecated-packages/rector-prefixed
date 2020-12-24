<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Autodiscovery\Tests\Rector\FileNode\MoveEntitiesToEntityDirectoryRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Autodiscovery\Rector\FileNode\MoveEntitiesToEntityDirectoryRector;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoper0a6b37af0871\Rector\FileSystemRector\ValueObject\AddedFileWithContent;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileSystem;
final class MoveEntitiesToEntityDirectoryRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $originalFileInfo, \_PhpScoper0a6b37af0871\Rector\FileSystemRector\ValueObject\AddedFileWithContent $expectedAddedFileWithContent) : void
    {
        $this->doTestFileInfo($originalFileInfo);
        $this->assertFileWithContentWasAdded($expectedAddedFileWithContent);
    }
    public function provideData() : \Iterator
    {
        $smartFileSystem = new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileSystem();
        (yield [new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/Controller/RandomEntity.php'), new \_PhpScoper0a6b37af0871\Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/Source/Entity/RandomEntity.php', $smartFileSystem->readFile(__DIR__ . '/Expected/ExpectedRandomEntity.php'))]);
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoper0a6b37af0871\Rector\Autodiscovery\Rector\FileNode\MoveEntitiesToEntityDirectoryRector::class;
    }
    protected function getPhpVersion() : int
    {
        return \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\PhpVersionFeature::TYPED_PROPERTIES - 1;
    }
}
