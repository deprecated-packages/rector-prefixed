<?php

declare (strict_types=1);
namespace Rector\RemovingStatic\Tests\Rector\StaticPropertyFetch\DesiredStaticPropertyFetchTypeToDynamicRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210309\Symplify\SmartFileSystem\SmartFileInfo;
final class DesiredStaticPropertyFetchTypeToDynamicRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210309\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function provideConfigFilePath() : string
    {
        return __DIR__ . '/config/some_config.php';
    }
}
