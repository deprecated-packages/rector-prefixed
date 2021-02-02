<?php

declare (strict_types=1);
namespace Rector\Privatization\Tests\Rector\MethodCall\ReplaceStringWithClassConstantRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210202\Symplify\SmartFileSystem\SmartFileInfo;
final class ReplaceStringWithClassConstantRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210202\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function provideConfigFileInfo() : ?\RectorPrefix20210202\Symplify\SmartFileSystem\SmartFileInfo
    {
        return new \RectorPrefix20210202\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/config/configured_config.php');
    }
}
