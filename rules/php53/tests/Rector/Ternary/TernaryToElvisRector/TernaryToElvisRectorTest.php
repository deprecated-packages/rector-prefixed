<?php

declare (strict_types=1);
namespace Rector\Php53\Tests\Rector\Ternary\TernaryToElvisRector;

use Iterator;
use Rector\Php53\Rector\Ternary\TernaryToElvisRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
final class TernaryToElvisRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Php53\Rector\Ternary\TernaryToElvisRector::class;
    }
}
