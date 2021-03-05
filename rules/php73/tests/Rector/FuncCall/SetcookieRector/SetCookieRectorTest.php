<?php

declare (strict_types=1);
namespace Rector\Php73\Tests\Rector\FuncCall\SetcookieRector;

use Iterator;
use Rector\Php73\Rector\FuncCall\SetCookieRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210305\Symplify\SmartFileSystem\SmartFileInfo;
final class SetCookieRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210305\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Php73\Rector\FuncCall\SetCookieRector::class;
    }
}
