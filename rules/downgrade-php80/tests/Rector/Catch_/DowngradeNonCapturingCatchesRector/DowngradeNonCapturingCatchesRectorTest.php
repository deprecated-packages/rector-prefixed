<?php

declare (strict_types=1);
namespace Rector\DowngradePhp80\Tests\Rector\Catch_\DowngradeNonCapturingCatchesRector;

use Iterator;
use Rector\DowngradePhp80\Rector\Catch_\DowngradeNonCapturingCatchesRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210125\Symplify\SmartFileSystem\SmartFileInfo;
final class DowngradeNonCapturingCatchesRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @requires PHP 8.0
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210125\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\DowngradePhp80\Rector\Catch_\DowngradeNonCapturingCatchesRector::class;
    }
}
