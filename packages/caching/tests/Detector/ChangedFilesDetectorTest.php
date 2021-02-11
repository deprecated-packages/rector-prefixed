<?php

declare (strict_types=1);
namespace Rector\Caching\Tests\Detector;

use Iterator;
use Rector\Caching\Detector\ChangedFilesDetector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210211\Symplify\SmartFileSystem\SmartFileInfo;
final class ChangedFilesDetectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @var ChangedFilesDetector
     */
    private $changedFilesDetector;
    protected function setUp() : void
    {
        parent::setUp();
        $this->changedFilesDetector = $this->getService(\Rector\Caching\Detector\ChangedFilesDetector::class);
    }
    protected function tearDown() : void
    {
        $this->changedFilesDetector->clear();
    }
    public function testHasFileChanged() : void
    {
        $smartFileInfo = new \RectorPrefix20210211\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/file.php');
        $this->assertTrue($this->changedFilesDetector->hasFileChanged($smartFileInfo));
        $this->changedFilesDetector->addFileWithDependencies($smartFileInfo, []);
        $this->assertFalse($this->changedFilesDetector->hasFileChanged($smartFileInfo));
        $this->changedFilesDetector->invalidateFile($smartFileInfo);
        $this->assertTrue($this->changedFilesDetector->hasFileChanged($smartFileInfo));
    }
    /**
     * @param string[] $dependantFiles
     * @dataProvider provideData()
     */
    public function testGetDependentFileInfos(string $filePathName, array $dependantFiles) : void
    {
        $smartFileInfo = new \RectorPrefix20210211\Symplify\SmartFileSystem\SmartFileInfo($filePathName);
        $this->changedFilesDetector->addFileWithDependencies($smartFileInfo, $dependantFiles);
        $dependantSmartFileInfos = $this->changedFilesDetector->getDependentFileInfos($smartFileInfo);
        $dependantFilesCount = \count($dependantFiles);
        $this->assertCount($dependantFilesCount, $dependantSmartFileInfos);
        foreach ($dependantFiles as $key => $dependantFile) {
            $this->assertSame($dependantFile, $dependantSmartFileInfos[$key]->getPathname());
        }
    }
    public function provideData() : \Iterator
    {
        (yield [__DIR__ . '/Source/file.php', []]);
        (yield [__DIR__ . '/Source/file.php', [__DIR__ . '/Source/file.php']]);
        (yield [__DIR__ . '/Source/file.php', [__DIR__ . '/Source/file.php', __DIR__ . '/Source/file2.php', __DIR__ . '/Source/file3.php']]);
    }
    protected function provideConfigFileInfo() : \RectorPrefix20210211\Symplify\SmartFileSystem\SmartFileInfo
    {
        return new \RectorPrefix20210211\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/config.php');
    }
}
