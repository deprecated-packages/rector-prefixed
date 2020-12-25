<?php

declare (strict_types=1);
namespace Rector\CodeQuality\Tests\Rector\Expression\InlineIfToExplicitIfRector;

use Iterator;
use Rector\CodeQuality\Rector\Expression\InlineIfToExplicitIfRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
final class InlineIfToExplicitIfRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return \Rector\CodeQuality\Rector\Expression\InlineIfToExplicitIfRector::class;
    }
}
