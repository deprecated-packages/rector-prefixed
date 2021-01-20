<?php

declare (strict_types=1);
namespace Rector\PHPUnitSymfony\Tests\Rector\StaticCall\AddMessageToEqualsResponseCodeRector;

use Iterator;
use Rector\PHPUnitSymfony\Rector\StaticCall\AddMessageToEqualsResponseCodeRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210120\Symplify\SmartFileSystem\SmartFileInfo;
final class AddMessageToEqualsResponseCodeRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210120\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\PHPUnitSymfony\Rector\StaticCall\AddMessageToEqualsResponseCodeRector::class;
    }
}
