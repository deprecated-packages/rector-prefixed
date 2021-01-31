<?php

declare (strict_types=1);
namespace Rector\DowngradePhp74\Tests\Rector\LNumber\DowngradeNumericLiteralSeparatorRector;

use Iterator;
use Rector\DowngradePhp74\Rector\LNumber\DowngradeNumericLiteralSeparatorRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210131\Symplify\SmartFileSystem\SmartFileInfo;
final class DowngradeNumericLiteralSeparatorRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @requires PHP 7.4
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210131\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\DowngradePhp74\Rector\LNumber\DowngradeNumericLiteralSeparatorRector::class;
    }
}
