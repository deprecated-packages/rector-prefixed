<?php

declare (strict_types=1);
namespace Rector\DoctrineGedmoToKnplabs\Tests\Rector\Class_\TreeBehaviorRector;

use Iterator;
use Rector\DoctrineGedmoToKnplabs\Rector\Class_\TreeBehaviorRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210211\Symplify\SmartFileSystem\SmartFileInfo;
final class TreeBehaviorRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210211\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\DoctrineGedmoToKnplabs\Rector\Class_\TreeBehaviorRector::class;
    }
}
