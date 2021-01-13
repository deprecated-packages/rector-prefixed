<?php

declare (strict_types=1);
namespace Rector\Phalcon\Tests\Rector\Assign\NewApplicationToToFactoryWithDefaultContainerRector;

use Iterator;
use Rector\Phalcon\Rector\Assign\NewApplicationToToFactoryWithDefaultContainerRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210113\Symplify\SmartFileSystem\SmartFileInfo;
final class NewApplicationToToFactoryWithDefaultContainerRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210113\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Phalcon\Rector\Assign\NewApplicationToToFactoryWithDefaultContainerRector::class;
    }
}
