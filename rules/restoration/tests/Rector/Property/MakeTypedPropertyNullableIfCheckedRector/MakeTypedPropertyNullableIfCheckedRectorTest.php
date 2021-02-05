<?php

declare (strict_types=1);
namespace Rector\Restoration\Tests\Rector\Property\MakeTypedPropertyNullableIfCheckedRector;

use Iterator;
use Rector\Restoration\Rector\Property\MakeTypedPropertyNullableIfCheckedRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210205\Symplify\SmartFileSystem\SmartFileInfo;
final class MakeTypedPropertyNullableIfCheckedRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @requires PHP 7.4
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210205\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Restoration\Rector\Property\MakeTypedPropertyNullableIfCheckedRector::class;
    }
}
