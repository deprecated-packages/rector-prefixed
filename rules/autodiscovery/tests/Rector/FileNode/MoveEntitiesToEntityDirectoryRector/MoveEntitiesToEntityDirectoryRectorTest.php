<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Autodiscovery\Tests\Rector\FileNode\MoveEntitiesToEntityDirectoryRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Autodiscovery\Rector\FileNode\MoveEntitiesToEntityDirectoryRector;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScopere8e811afab72\Rector\FileSystemRector\ValueObject\AddedFileWithContent;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem;
final class MoveEntitiesToEntityDirectoryRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $originalFileInfo, \_PhpScopere8e811afab72\Rector\FileSystemRector\ValueObject\AddedFileWithContent $expectedAddedFileWithContent) : void
    {
        $this->doTestFileInfo($originalFileInfo);
        $this->assertFileWithContentWasAdded($expectedAddedFileWithContent);
    }
    public function provideData() : \Iterator
    {
        $smartFileSystem = new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem();
        (yield [new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/Controller/RandomEntity.php'), new \_PhpScopere8e811afab72\Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/Source/Entity/RandomEntity.php', $smartFileSystem->readFile(__DIR__ . '/Expected/ExpectedRandomEntity.php'))]);
    }
    protected function getRectorClass() : string
    {
        return \_PhpScopere8e811afab72\Rector\Autodiscovery\Rector\FileNode\MoveEntitiesToEntityDirectoryRector::class;
    }
    protected function getPhpVersion() : int
    {
        return \_PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature::TYPED_PROPERTIES - 1;
    }
}
