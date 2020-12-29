<?php

declare (strict_types=1);
namespace Rector\Twig\Tests\Rector\Return_\SimpleFunctionAndFilterRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Rector\Twig\Rector\Return_\SimpleFunctionAndFilterRector;
use RectorPrefix20201229\Symplify\SmartFileSystem\SmartFileInfo;
final class SimpleFunctionAndFilterRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20201229\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Twig\Rector\Return_\SimpleFunctionAndFilterRector::class;
    }
}
