<?php

declare (strict_types=1);
namespace Rector\Privatization\Tests\Rector\ClassMethod\PrivatizeLocalOnlyMethodRector;

use Iterator;
use Rector\Privatization\Rector\ClassMethod\PrivatizeLocalOnlyMethodRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210204\Symplify\SmartFileSystem\SmartFileInfo;
final class PrivatizeLocalOnlyMethodRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210204\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Privatization\Rector\ClassMethod\PrivatizeLocalOnlyMethodRector::class;
    }
}
