<?php

declare (strict_types=1);
namespace Rector\Doctrine\Tests\Rector\Class_\RemoveRepositoryFromEntityAnnotationRector;

use Iterator;
use Rector\Doctrine\Rector\Class_\RemoveRepositoryFromEntityAnnotationRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210308\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveRepositoryFromEntityAnnotationRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210308\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Doctrine\Rector\Class_\RemoveRepositoryFromEntityAnnotationRector::class;
    }
}
