<?php

declare (strict_types=1);
namespace Rector\DowngradePhp71\Tests\Rector\Array_\SymmetricArrayDestructuringToListRector;

use Iterator;
use Rector\DowngradePhp71\Rector\Array_\SymmetricArrayDestructuringToListRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210223\Symplify\SmartFileSystem\SmartFileInfo;
final class SymmetricArrayDestructuringToListRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @requires PHP 7.1
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210223\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\DowngradePhp71\Rector\Array_\SymmetricArrayDestructuringToListRector::class;
    }
}
