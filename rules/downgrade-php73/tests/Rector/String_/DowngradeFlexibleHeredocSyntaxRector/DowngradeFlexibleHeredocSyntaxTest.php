<?php

declare (strict_types=1);
namespace Rector\DowngradePhp73\Tests\Rector\String_\DowngradeFlexibleHeredocSyntaxRector;

use Iterator;
use Rector\DowngradePhp73\Rector\String_\DowngradeFlexibleHeredocSyntaxRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210111\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @requires PHP >= 7.3
 */
final class DowngradeFlexibleHeredocSyntaxTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210111\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\DowngradePhp73\Rector\String_\DowngradeFlexibleHeredocSyntaxRector::class;
    }
}
