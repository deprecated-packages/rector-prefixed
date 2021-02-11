<?php

declare (strict_types=1);
namespace Rector\Php70\Tests\Rector\StaticCall\StaticCallOnNonStaticToInstanceCallRector;

use Iterator;
use Rector\Php70\Rector\StaticCall\StaticCallOnNonStaticToInstanceCallRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210211\Symplify\SmartFileSystem\SmartFileInfo;
final class StaticCallOnNonStaticToInstanceCallRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     * @requires PHP < 8.0
     */
    public function test(\RectorPrefix20210211\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Php70\Rector\StaticCall\StaticCallOnNonStaticToInstanceCallRector::class;
    }
}
