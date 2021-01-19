<?php

declare (strict_types=1);
namespace Rector\Composer\Tests\Rector\MovePackageToRequireDevRector;

use Iterator;
use Rector\Composer\Tests\Rector\AbstractComposerRectorTestCase;
use RectorPrefix20210119\Symplify\EasyTesting\DataProvider\StaticFixtureFinder;
use RectorPrefix20210119\Symplify\SmartFileSystem\SmartFileInfo;
final class MovePackageToRequireDevRectorTest extends \Rector\Composer\Tests\Rector\AbstractComposerRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210119\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return \RectorPrefix20210119\Symplify\EasyTesting\DataProvider\StaticFixtureFinder::yieldDirectory(__DIR__ . '/Fixture', '*.json');
    }
    public function provideConfigFile() : string
    {
        return __DIR__ . '/config/some_config.php';
    }
}
