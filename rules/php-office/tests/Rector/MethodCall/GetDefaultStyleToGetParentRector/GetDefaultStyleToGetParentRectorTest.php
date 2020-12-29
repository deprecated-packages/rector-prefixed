<?php

declare (strict_types=1);
namespace Rector\PHPOffice\Tests\Rector\MethodCall\GetDefaultStyleToGetParentRector;

use Iterator;
use Rector\PHPOffice\Rector\MethodCall\GetDefaultStyleToGetParentRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20201229\Symplify\SmartFileSystem\SmartFileInfo;
final class GetDefaultStyleToGetParentRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20201229\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\PHPOffice\Rector\MethodCall\GetDefaultStyleToGetParentRector::class;
    }
}
