<?php

declare (strict_types=1);
namespace Rector\Php72\Tests\Rector\Assign\ListEachRector;

use Iterator;
use Rector\Php72\Rector\Assign\ListEachRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210124\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * Test battery inspired by:
 * - https://stackoverflow.com/q/46492621/1348344 + Drupal refactorings
 * - https://stackoverflow.com/a/51278641/1348344
 */
final class ListEachRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     * @requires PHP < 8.0
     */
    public function test(\RectorPrefix20210124\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Php72\Rector\Assign\ListEachRector::class;
    }
}
