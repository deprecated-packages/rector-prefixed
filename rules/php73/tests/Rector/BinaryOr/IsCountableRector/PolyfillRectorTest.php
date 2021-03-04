<?php

declare (strict_types=1);
namespace Rector\Php73\Tests\Rector\BinaryOr\IsCountableRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210304\Symplify\SmartFileSystem\SmartFileInfo;
final class PolyfillRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210304\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureWithPolyfill');
    }
    protected function provideConfigFilePath() : string
    {
        return __DIR__ . '/config/polyfill_config.php';
    }
}
