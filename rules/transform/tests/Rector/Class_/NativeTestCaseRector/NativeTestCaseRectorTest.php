<?php

declare (strict_types=1);
namespace Rector\Transform\Tests\Rector\Class_\NativeTestCaseRector;

use Iterator;
use Rector\FileSystemRector\ValueObject\AddedFileWithContent;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210306\Symplify\SmartFileSystem\SmartFileInfo;
use RectorPrefix20210306\Symplify\SmartFileSystem\SmartFileSystem;
final class NativeTestCaseRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210306\Symplify\SmartFileSystem\SmartFileInfo $fileInfo, \Rector\FileSystemRector\ValueObject\AddedFileWithContent $addedFileWithContent) : void
    {
        $this->doTestFileInfo($fileInfo);
        $this->assertFileWithContentWasAdded($addedFileWithContent);
    }
    public function provideData() : \Iterator
    {
        $smartFileSystem = new \RectorPrefix20210306\Symplify\SmartFileSystem\SmartFileSystem();
        (yield [new \RectorPrefix20210306\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Fixture/some_class.php.inc'), new \Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/config/configured_rule.php', $smartFileSystem->readFile(__DIR__ . '/Expected/config/configured_rule.php'))]);
    }
    protected function provideConfigFilePath() : string
    {
        return __DIR__ . '/config/configured_rule.php';
    }
}