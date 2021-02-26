<?php

declare (strict_types=1);
namespace Rector\DowngradePhp71\Tests\Rector\String_\DowngradeNegativeStringOffsetToStrlenRector;

use Iterator;
use Rector\DowngradePhp71\Rector\String_\DowngradeNegativeStringOffsetToStrlenRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210226\Symplify\SmartFileSystem\SmartFileInfo;
final class DowngradeNegativeStringOffsetToStrlenRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @requires PHP 7.1
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210226\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\DowngradePhp71\Rector\String_\DowngradeNegativeStringOffsetToStrlenRector::class;
    }
}
