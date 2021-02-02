<?php

declare (strict_types=1);
namespace Rector\Laravel\Tests\Rector\StaticCall\RequestStaticValidateToInjectRector;

use Iterator;
use Rector\Laravel\Rector\StaticCall\RequestStaticValidateToInjectRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210202\Symplify\SmartFileSystem\SmartFileInfo;
final class RequestStaticValidateToInjectRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210202\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Laravel\Rector\StaticCall\RequestStaticValidateToInjectRector::class;
    }
}
