<?php

declare (strict_types=1);
namespace Rector\Php53\Tests\Rector\Variable\ReplaceHttpServerVarsByServerRector;

use Iterator;
use Rector\Php53\Rector\Variable\ReplaceHttpServerVarsByServerRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use SplFileInfo;
use RectorPrefix20210228\Symplify\SmartFileSystem\SmartFileInfo;
final class ReplaceHttpServerVarsByServerRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210228\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    /**
     * @return Iterator<SplFileInfo>
     */
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Php53\Rector\Variable\ReplaceHttpServerVarsByServerRector::class;
    }
}
