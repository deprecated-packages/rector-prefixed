<?php

declare (strict_types=1);
namespace Rector\Composer\Tests\Rector\MovePackageToRequireRector;

use Iterator;
use Rector\Composer\Tests\Rector\AbstractComposerRectorTestCase;
use RectorPrefix20210118\Symplify\EasyTesting\DataProvider\StaticFixtureFinder;
use RectorPrefix20210118\Symplify\SmartFileSystem\SmartFileInfo;
final class MovePackageToRequireRectorTest extends \Rector\Composer\Tests\Rector\AbstractComposerRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210118\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return \RectorPrefix20210118\Symplify\EasyTesting\DataProvider\StaticFixtureFinder::yieldDirectory(__DIR__ . '/Fixture', '*.json');
    }
    public function provideConfigFile() : string
    {
        return __DIR__ . '/config/some_config.php';
    }
}
