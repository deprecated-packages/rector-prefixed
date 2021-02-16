<?php

declare (strict_types=1);
namespace Rector\DowngradePhp74\Tests\Rector\Property\DowngradeTypedPropertyRector;

use Iterator;
use Rector\DowngradePhp74\Rector\Property\DowngradeTypedPropertyRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210216\Symplify\SmartFileSystem\SmartFileInfo;
final class DowngradeTypedPropertyRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @requires PHP 7.4
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210216\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\DowngradePhp74\Rector\Property\DowngradeTypedPropertyRector::class;
    }
}
