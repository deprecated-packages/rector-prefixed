<?php

declare (strict_types=1);
namespace Rector\Symfony4\Tests\Rector\ConstFetch\ConstraintUrlOptionRector;

use Iterator;
use Rector\Symfony4\Rector\ConstFetch\ConstraintUrlOptionRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210128\Symplify\SmartFileSystem\SmartFileInfo;
final class ConstraintUrlOptionRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210128\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Symfony4\Rector\ConstFetch\ConstraintUrlOptionRector::class;
    }
}
