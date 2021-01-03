<?php

declare (strict_types=1);
namespace Rector\Php73\Tests\Rector\String_\SensitiveHereNowDocRector;

use Iterator;
use Rector\Php73\Rector\String_\SensitiveHereNowDocRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210103\Symplify\SmartFileSystem\SmartFileInfo;
final class SensitiveHereNowDocRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210103\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Php73\Rector\String_\SensitiveHereNowDocRector::class;
    }
}
