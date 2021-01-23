<?php

declare (strict_types=1);
namespace Rector\JMS\Tests\Rector\Class_\RemoveJmsInjectServiceAnnotationRector;

use Iterator;
use Rector\JMS\Rector\Class_\RemoveJmsInjectServiceAnnotationRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210123\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveJmsInjectServiceAnnotationRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210123\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\JMS\Rector\Class_\RemoveJmsInjectServiceAnnotationRector::class;
    }
}
