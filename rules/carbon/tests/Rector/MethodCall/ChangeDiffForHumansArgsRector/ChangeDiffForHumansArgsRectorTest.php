<?php

declare (strict_types=1);
namespace Rector\Carbon\Tests\Rector\MethodCall\ChangeDiffForHumansArgsRector;

use Iterator;
use Rector\Carbon\Rector\MethodCall\ChangeDiffForHumansArgsRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210209\Symplify\SmartFileSystem\SmartFileInfo;
final class ChangeDiffForHumansArgsRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210209\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Carbon\Rector\MethodCall\ChangeDiffForHumansArgsRector::class;
    }
}
